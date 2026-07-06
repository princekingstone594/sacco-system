<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with(['member', 'account', 'postedBy'])
            ->latest('transacted_at')
            ->latest()
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request): View
    {
        $accounts = Account::with('member')->where('status', 'active')->orderBy('account_no')->get();
        $selectedAccount = $request->integer('account_id');

        return view('transactions.create', [
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,
            'types' => Transaction::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'type' => ['required', Rule::in(array_keys(Transaction::TYPES))],
            'amount' => ['required', 'numeric', 'min:1'],
            'reference' => ['nullable', 'string', 'max:120'],
            'transacted_at' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $account = Account::lockForUpdate()->with('member')->findOrFail($data['account_id']);
            $amount = (float) $data['amount'];
            $signedAmount = in_array($data['type'], ['withdrawal', 'fee'], true) ? -$amount : $amount;

            if ($account->balance + $signedAmount < 0) {
                abort(422, 'This transaction would overdraw the account.');
            }

            $account->increment('balance', $signedAmount);

            Transaction::create([
                ...$data,
                'member_id' => $account->member_id,
                'posted_by' => $request->user()->id,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction posted.');
    }
}
