<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $loans = Loan::with(['member', 'product'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('loans.index', compact('loans', 'status'));
    }

    public function create(): View
    {
        return view('loans.create', [
            'members' => Member::where('status', 'active')->orderBy('first_name')->get(),
            'products' => LoanProduct::where('status', 'active')->orderBy('name')->get(),
            'loan' => new Loan([
                'issued_on' => now(),
                'status' => 'pending', // 🔥 default now pending
            ]),
        ]);
    }

    /**
     * STORE (CORE LOGIC)
     * Handles BOTH:
     * - Member applies → pending
     * - Admin creates → approved
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $product = LoanProduct::findOrFail($data['loan_product_id']);
        $principal = (float) $data['principal'];

        // Validate limits
        if (
            $principal < (float) $product->minimum_amount ||
            ($product->maximum_amount && $principal > (float) $product->maximum_amount)
        ) {
            return back()
                ->withErrors(['principal' => 'Amount must be within product limits'])
                ->withInput();
        }

        $issuedOn = Carbon::parse($data['issued_on']);

        // Simple interest calc
        $interest = $principal * ($product->interest_rate / 100);
        $totalPayable = $principal + $interest;

        // 🔥 KEY LOGIC: WHO IS CREATING?
        $status = auth()->user()->role === 'admin'
            ? 'approved'
            : 'pending';

        Loan::create([
            ...$data,
            'status' => $status,
            'interest_rate' => $product->interest_rate,
            'term_months' => $product->term_months,
            'total_payable' => $totalPayable,
            'balance' => $totalPayable,
            'due_on' => $issuedOn->copy()->addMonths($product->term_months),
        ]);

        return redirect()
            ->route('loans.index')
            ->with('success', $status === 'pending'
                ? 'Loan application submitted'
                : 'Loan created and approved');
    }

    public function show(Loan $loan): View
    {
        $loan->load(['member', 'product', 'repayments.postedBy']);
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan): View
    {
        return view('loans.edit', [
            'loan' => $loan,
            'members' => Member::orderBy('first_name')->get(),
            'products' => LoanProduct::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Loan $loan): RedirectResponse
    {
        $loan->update($request->validate([
            'loan_no' => ['required', 'string', 'max:50', Rule::unique('loans')->ignore($loan->id)],
            'status' => ['required', Rule::in(['pending','approved','disbursed','completed','rejected'])],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]));

        return redirect()->route('loans.show', $loan)->with('success', 'Loan updated.');
    }

    public function destroy(Loan $loan): RedirectResponse
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan removed.');
    }

    /**
     * REPAYMENT
     */
    public function repay(Request $request, Loan $loan): RedirectResponse
    {
        if ($loan->status !== 'disbursed') {
            return back()->with('error', 'Loan must be disbursed first');
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'reference' => ['nullable', 'string', 'max:120'],
            'paid_on' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($loan, $data, $request) {
            $loan = Loan::lockForUpdate()->findOrFail($loan->id);

            $amount = min($data['amount'], $loan->balance);

            $loan->repayments()->create([
                ...$data,
                'amount' => $amount,
                'posted_by' => $request->user()->id,
            ]);

            $loan->decrement('balance', $amount);
            $loan->refresh();

            if ($loan->balance <= 0) {
                $loan->update([
                    'status' => 'completed',
                    'balance' => 0
                ]);
            }
        });

        return back()->with('success', 'Repayment recorded.');
    }

    /**
     * APPROVE
     */
    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Only pending loans can be approved');
        }

        $loan->update(['status' => 'approved']);

        return back()->with('success', 'Loan approved');
    }

    /**
     * REJECT
     */
    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Only pending loans can be rejected');
        }

        $loan->update(['status' => 'rejected']);

        return back()->with('error', 'Loan rejected');
    }

    /**
     * DISBURSE (CRITICAL FIXED)
     */
    public function disburse(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Loan must be approved first');
        }

        $account = $loan->member->accounts()->first();

        if (!$account) {
            return back()->with('error', 'Member has no account');
        }

        DB::transaction(function () use ($loan, $account) {

            // ✅ FIXED (was amount ❌)
            $account->increment('balance', $loan->principal);

            Transaction::create([
                'member_id' => $loan->member_id,
                'account_id' => $account->id,
                'type' => 'loan_disbursement',
                'amount' => $loan->principal,
                'transacted_at' => now(),
            ]);

            $loan->update([
                'status' => 'disbursed'
            ]);
        });

        return back()->with('success', 'Loan disbursed successfully');
    }

    /**
     * VALIDATION
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'loan_product_id' => ['required', 'exists:loan_products,id'],
            'loan_no' => ['required', 'string', 'max:50', 'unique:loans,loan_no'],
            'principal' => ['required', 'numeric', 'min:1'],
            'issued_on' => ['required', 'date'],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}