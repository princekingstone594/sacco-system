<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Member;
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
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest('issued_on')
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
            'loan' => new Loan(['issued_on' => now(), 'status' => 'active']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $product = LoanProduct::findOrFail($data['loan_product_id']);
        $principal = (float) $data['principal'];

        if ($principal < (float) $product->minimum_amount || ($product->maximum_amount && $principal > (float) $product->maximum_amount)) {
            return back()->withErrors(['principal' => 'Amount must be within the selected product limits.'])->withInput();
        }

        $issuedOn = Carbon::parse($data['issued_on']);
        $interest = $principal * ((float) $product->interest_rate / 100);
        $totalPayable = $principal + $interest;

        Loan::create([
            ...$data,
            'interest_rate' => $product->interest_rate,
            'term_months' => $product->term_months,
            'total_payable' => $totalPayable,
            'balance' => $totalPayable,
            'due_on' => $issuedOn->copy()->addMonths($product->term_months),
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan issued.');
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
            'status' => ['required', Rule::in(['active', 'paid', 'defaulted', 'written_off'])],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]));

        return redirect()->route('loans.show', $loan)->with('success', 'Loan updated.');
    }

    public function destroy(Loan $loan): RedirectResponse
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan removed.');
    }

    public function repay(Request $request, Loan $loan): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'reference' => ['nullable', 'string', 'max:120'],
            'paid_on' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($loan, $data, $request) {
            $loan = Loan::lockForUpdate()->findOrFail($loan->id);
            $amount = min((float) $data['amount'], (float) $loan->balance);

            $loan->repayments()->create([
                ...$data,
                'amount' => $amount,
                'posted_by' => $request->user()->id,
            ]);

            $loan->decrement('balance', $amount);
            $loan->refresh();

            if ((float) $loan->balance <= 0) {
                $loan->update(['status' => 'paid', 'balance' => 0]);
            }
        });

        return redirect()->route('loans.show', $loan)->with('success', 'Repayment recorded.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'loan_product_id' => ['required', 'exists:loan_products,id'],
            'loan_no' => ['required', 'string', 'max:50', 'unique:loans,loan_no'],
            'principal' => ['required', 'numeric', 'min:1'],
            'issued_on' => ['required', 'date'],
            'status' => ['required', Rule::in(['active', 'paid', 'defaulted', 'written_off'])],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
