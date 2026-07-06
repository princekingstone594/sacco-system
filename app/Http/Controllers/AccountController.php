<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();

        $accounts = Account::with('member')
            ->when($type, fn ($query) => $query->where('type', $type))
            ->orderBy('type')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('accounts.index', [
            'accounts' => $accounts,
            'types' => Account::TYPES,
            'type' => $type,
        ]);
    }

    public function show(Account $account): View
    {
        $account->load('member');

        $transactions = $account->transactions()
            ->with('postedBy')
            ->latest('transacted_at')
            ->latest()
            ->paginate(15);

        return view('accounts.show', compact('account', 'transactions'));
    }
}
