<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\AuditLog;
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
            ->latest()
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (DEPOSIT / WITHDRAW)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'type'       => ['required', Rule::in(['deposit', 'withdraw', 'withdrawal'])],
            'amount'     => ['required', 'numeric', 'min:1'],
            'transacted_at' => ['nullable', 'date'],
            'description'=> ['nullable', 'string'],
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($data, $user) {

            $account = Account::lockForUpdate()->findOrFail($data['account_id']);

            // 💰 Handle balance
            $type = $data['type'] === 'withdraw' ? 'withdrawal' : $data['type'];

            if ($type === 'deposit') {
                $account->balance += $data['amount'];
            } else {
                if ($account->balance < $data['amount']) {
                    abort(400, 'Insufficient balance');
                }
                $account->balance -= $data['amount'];
            }

            $account->save();

            // 🧾 Create transaction
            $transaction = Transaction::create([
                'account_id'  => $account->id,
                'member_id'   => $account->member_id,
                'type'        => $type,
                'amount'      => $data['amount'],
                'transacted_at' => $data['transacted_at'] ?? now()->toDateString(),
                'description' => $data['description'] ?? null,
                'posted_by'   => $user->id,
            ]);

            // 🛡️ AUDIT LOG (THIS IS STEP 6.4)
            AuditLog::create([
                'user_id' => $user->id,
                'action'  => strtoupper($type),
                'entity'  => 'transaction',
                'entity_id' => $transaction->id,
                'meta' => json_encode([
                    'amount' => $data['amount'],
                    'account_id' => $account->id,
                ]),
            ]);
        });

        // 🔁 JSON for your realtime wallet UI
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction successful'
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction successful');
    }
}
