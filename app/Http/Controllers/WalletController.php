<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
       $user = auth()->user();
       $member = $user->member;

       $balance = $member
          ? $member->accounts()->sum('balance')
          : 0;

       $transactions = \App\Models\Transaction::whereHas('account', function ($q) use ($member) {
              $q->where('member_id', $member->id ?? 0);
          })
          ->latest('transacted_at')
          ->limit(10)
          ->get();

        return view('wallet.index', compact('balance', 'transactions'));
  }
}

