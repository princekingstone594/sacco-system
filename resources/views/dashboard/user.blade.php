@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- 🔥 HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Welcome back, {{ auth()->user()->name }}
            </h1>
            <p class="text-sm text-gray-500">Your financial overview</p>
        </div>

        <div class="text-right">
            <p class="text-xs text-gray-400">Available Balance</p>
            <h2 class="text-3xl font-bold text-indigo-600">
                ${{ number_format($balance, 2) }}
            </h2>
        </div>
    </div>


    {{-- 💳 STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Savings --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-sm text-gray-500">Savings</p>
            <h3 class="text-xl font-semibold text-gray-800 mt-1">
                ${{ number_format($savings, 2) }}
            </h3>
        </div>

        {{-- Active Loans --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-sm text-gray-500">Active Loans</p>
            <h3 class="text-xl font-semibold text-gray-800 mt-1">
                {{ $activeLoans }}
            </h3>
        </div>

        {{-- Loan Balance --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-sm text-gray-500">Loan Exposure</p>
            <h3 class="text-xl font-semibold text-red-500 mt-1">
                ${{ number_format($loanBalance, 2) }}
            </h3>
        </div>

    </div>


    {{-- 📊 MINI INSIGHT SECTION --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- Activity --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Recent Activity
            </h3>

            @forelse($transactions as $tx)
                <div class="flex justify-between items-center py-2 border-b last:border-none">
                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            {{ ucfirst($tx->type) }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $tx->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="text-sm font-semibold 
                        {{ $tx->type == 'deposit' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $tx->type == 'deposit' ? '+' : '-' }}
                        ${{ number_format($tx->amount, 2) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-400">No transactions yet</p>
            @endforelse
        </div>


        {{-- Loans Overview --}}
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Loans Overview
            </h3>

            @forelse($loans as $loan)
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">
                            ${{ number_format($loan->amount, 2) }}
                        </span>
                        <span class="capitalize text-xs px-2 py-1 rounded-full 
                            {{ $loan->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $loan->status }}
                        </span>
                    </div>

                    {{-- Fake progress bar (upgrade later with real %) --}}
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full w-1/2"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400">No loans yet</p>
            @endforelse
        </div>

    </div>


    {{-- 🚀 QUICK ACTIONS --}}
    <div class="bg-white rounded-2xl shadow p-5 flex justify-between items-center">

        <div>
            <h3 class="text-lg font-semibold text-gray-700">
                Quick Actions
            </h3>
            <p class="text-sm text-gray-400">
                Manage your finances quickly
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('wallet.index') }}"
               class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                Open Wallet
            </a>

            <a href="#"
               class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300">
                Apply Loan
            </a>
        </div>

    </div>

</div>
@endsection