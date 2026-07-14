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
    /*
    |--------------------------------------------------------------------------
    | LIST TRANSACTIONS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $type = $request->get('type');

        $transactions = Transaction::with(['member', 'account', 'postedBy'])
            ->when($type, fn ($q) => $q->where('type', $type))
            ->latest('transacted_at')
            ->paginate(15)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'type'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE GENERAL TRANSACTION (ADMIN STYLE)
    |--------------------------------------------------------------------------
    */
    public function create(Request $request): View
    {
        $accounts = Account::with('member')
            ->where('status', 'active')
            ->orderBy('account_no')
            ->get();

        $selectedAccount = $request->integer('account_id');

        return view('transactions.create', [
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,
            'types' => Transaction::TYPES,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE GENERAL TRANSACTION (DEPOSIT / WITHDRAW / FEE)
    |--------------------------------------------------------------------------
    */
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

            $account = Account::lockForUpdate()
                ->with('member')
                ->findOrFail($data['account_id']);

            $amount = (float) $data['amount'];

            // Determine direction
            $signedAmount = in_array($data['type'], ['withdrawal', 'fee'], true)
                ? -$amount
                : $amount;

            // Prevent overdraft
            if ($account->balance + $signedAmount < 0) {
                abort(422, 'This transaction would overdraw the account.');
            }

            // Update balance
            $account->increment('balance', $signedAmount);

            // Save transaction
            Transaction::create([
                ...$data,
                'member_id' => $account->member_id,
                'posted_by' => $request->user()->id,
            ]);
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction posted successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | WALLET: SIMPLE DEPOSIT FORM (USER)
    |--------------------------------------------------------------------------
    */
    public function createSavings(): View
    {
        $member = auth()->user()->member;

        return view('savings.create', compact('member'));
    }


    /*
    |--------------------------------------------------------------------------
    | WALLET: STORE DEPOSIT (USER FRIENDLY)
    |--------------------------------------------------------------------------
    */
    public function storeSavings(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $member = auth()->user()->member;

        if (!$member) {
            return back()->with('error', 'Member profile not found.');
        }

        DB::transaction(function () use ($member, $request) {

            // 🔥 Find or create savings account
            $account = Account::firstOrCreate(
                [
                    'member_id' => $member->id,
                    'type' => 'savings',
                ],
                [
                    'balance' => 0,
                    'status' => 'active',
                ]
            );

            $amount = (float) $request->amount;

            // Update balance
            $account->increment('balance', $amount);

            // Record transaction (standardized)
            Transaction::create([
                'account_id' => $account->id,
                'member_id' => $member->id,
                'type' => 'deposit',
                'amount' => $amount,
                'transacted_at' => now(),
                'posted_by' => auth()->id(),
                'description' => 'Wallet deposit',
            ]);
        });

        return redirect()->route('wallet')
            ->with('success', 'Deposit successful.');
    }

    public function deposit(Request $request)
    {
      $data = $request->validate([
        'amount' => ['required', 'numeric', 'min:1'],
      ]);

      return DB::transaction(function () use ($data, $request) {

        $member = $request->user()->member;

        $account = $member->accounts()->lockForUpdate()->first();

        if (!$account) {
            return response()->json(['message' => 'No account found'], 404);
        }

        $account->increment('balance', $data['amount']);

        Transaction::create([
            'member_id' => $member->id,
            'account_id' => $account->id,
            'type' => 'deposit',
            'amount' => $data['amount'],
            'transacted_at' => now(),
            'posted_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Deposit successful',
            'balance' => $account->balance
        ]);
    });
    }


    public function withdraw(Request $request)
    {
       $data = $request->validate([
        'amount' => ['required', 'numeric', 'min:1'],
        ]);

        return DB::transaction(function () use ($data, $request) {

         $member = $request->user()->member;

         $account = $member->accounts()->lockForUpdate()->first();

         if (!$account) {
            return response()->json(['message' => 'No account found'], 404);
         }

         if ($account->balance < $data['amount']) {
            return response()->json([
                'message' => 'Insufficient balance'
            ], 422);
         }

         $account->decrement('balance', $data['amount']);

         Transaction::create([
            'member_id' => $member->id,
            'account_id' => $account->id,
            'type' => 'withdrawal',
            'amount' => $data['amount'],
            'transacted_at' => now(),
            'posted_by' => $request->user()->id,
         ]);

         return response()->json([
            'message' => 'Withdrawal successful',
            'balance' => $account->balance
         ]);
        });
    }
}