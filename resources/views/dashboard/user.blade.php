@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- 🔥 HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-[#241f2f]">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="text-sm text-[#716a7c]">Your Royalty Sacco financial overview</p>
        </div>

        <div class="text-right">
            <p class="text-xs font-bold uppercase text-[#716a7c]">Available Balance</p>
            <h2 class="text-3xl font-extrabold text-[#4b2673]">
                KES {{ number_format($balance, 2) }}
            </h2>
        </div>
    </div>


    {{-- 💳 STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Savings --}}
        <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5">
            <p class="text-sm text-[#716a7c]">Savings</p>
            <h3 class="text-xl font-extrabold text-[#241f2f] mt-1">
                KES {{ number_format($savings, 2) }}
            </h3>
        </div>

        {{-- Active Loans --}}
        <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5">
            <p class="text-sm text-[#716a7c]">Active Loans</p>
            <h3 class="text-xl font-extrabold text-[#241f2f] mt-1">
                {{ $activeLoans }}
            </h3>
        </div>

        {{-- Loan Balance --}}
        <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5">
            <p class="text-sm text-[#716a7c]">Loan Exposure</p>
            <h3 class="text-xl font-extrabold text-[#b33636] mt-1">
                KES {{ number_format($loanBalance, 2) }}
            </h3>
        </div>

    </div>


    {{-- 📊 MINI INSIGHT SECTION --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- Activity --}}
        <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5">
            <h3 class="text-lg font-extrabold text-[#241f2f] mb-4">
                Recent Activity
            </h3>

            @forelse($transactions as $tx)
                <div class="flex justify-between items-center py-2 border-b last:border-none">
                    <div>
                        <p class="text-sm font-bold text-[#241f2f]">
                            {{ ucfirst($tx->type) }}
                        </p>
                        <p class="text-xs text-[#716a7c]">
                            {{ $tx->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="text-sm font-semibold 
                        {{ $tx->type == 'deposit' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $tx->type == 'deposit' ? '+' : '-' }}
                        KES {{ number_format($tx->amount, 2) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No transactions yet</p>
            @endforelse
        </div>


        {{-- Loans Overview --}}
        <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5">
            <h3 class="text-lg font-extrabold text-[#241f2f] mb-4">
                Loans Overview
            </h3>

            @forelse($loans as $loan)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-[#5f5968]">
                            KES {{ number_format($loan->principal ?? $loan->amount ?? 0, 2) }}
                        </span>
                        <span class="capitalize text-xs px-2 py-1 rounded-full 
                            {{ $loan->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $loan->status }}
                        </span>
                    </div>

                    {{-- Fake progress bar (upgrade later with real %) --}}
                    <div class="w-full bg-[#eee8dc] rounded-full h-2">
                        <div class="bg-[#4b2673] h-2 rounded-full" style="width: {{ ($loan->total_payable ?? 0) > 0 ? max(5, min(100, (($loan->total_payable - $loan->balance) / $loan->total_payable) * 100)) : 5 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No loans yet</p>
            @endforelse
        </div>

    </div>


    {{-- 🚀 QUICK ACTIONS --}}
    <div class="bg-white rounded-lg border border-[#ded8c8] shadow-sm p-5 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">

        <div>
            <h3 class="text-lg font-extrabold text-[#241f2f]">
                Quick Actions
            </h3>
            <p class="text-sm text-[#716a7c]">
                Manage your finances quickly
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('wallet.index') }}"
               class="px-4 py-2 bg-[#4b2673] text-white text-sm font-bold rounded-md hover:bg-[#3d1d61]">
                Open Wallet
            </a>

            <a href="{{ route('loans.create') }}"
               class="px-4 py-2 bg-[#f1cc4b] text-[#241f2f] text-sm font-extrabold rounded-md hover:bg-[#e1bb37]">
                Apply Loan
            </a>
        </div>

    </div>

</div>
@endsection
