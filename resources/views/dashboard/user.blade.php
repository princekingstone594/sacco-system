@extends('layouts.app')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

@php
    $dashboardUser = auth()->user();
@endphp

<div class="space-y-8" x-data="{ showMoney: false }">

    <section class="relative overflow-hidden rounded-lg bg-[#241f2f] text-white shadow-sm">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=1800&q=85" alt="Savings growth" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-[#241f2f]/75"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#241f2f] via-[#241f2f]/88 to-[#241f2f]/35"></div>
        </div>

        <div class="relative grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr_0.9fr] lg:p-10">
            <div class="flex min-h-[360px] flex-col justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-wide text-[#f1cc4b]">Royalty Sacco SaaS</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">
                        Grow savings, manage loans, and track every shilling from one portal.
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-white/80">
                        Welcome back, {{ $dashboardUser->name }}. Your dashboard is now a clean home base for savings, credit, wallet activity, and customer support.
                    </p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('wallet.index') }}" class="rounded-md bg-[#f1cc4b] px-5 py-3 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">Open Wallet</a>
                    <a href="{{ route('loans.create') }}" class="rounded-md border border-white/25 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Apply Loan</a>
                    <a href="{{ route('customer-care.create') }}" class="rounded-md border border-white/25 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Ask Customer Care</a>
                </div>
            </div>

            <div class="flex flex-col justify-end">
                <div class="rounded-lg border border-white/15 bg-white/95 p-5 text-[#241f2f] shadow-sm backdrop-blur">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-14 w-14 overflow-hidden rounded-full bg-[#f6f1e6]">
                                @if ($dashboardUser->profile_photo_path)
                                    <img src="{{ asset('storage/'.$dashboardUser->profile_photo_path) }}" alt="{{ $dashboardUser->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xl font-extrabold text-[#4b2673]">
                                        {{ strtoupper(substr($dashboardUser->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-extrabold">{{ $dashboardUser->name }}</p>
                                <p class="text-xs font-semibold text-[#716a7c]">Member account</p>
                            </div>
                        </div>
                        <button type="button"
                            @click="showMoney = ! showMoney"
                            :aria-label="showMoney ? 'Hide balances' : 'Show balances'"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-[#ded8c8] text-[#4b2673] hover:bg-[#f6f1e6]">
                            <svg x-show="! showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5Z" />
                            </svg>
                            <svg x-show="showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2 2 0 0 0 13.4 13.4" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.45A9.14 9.14 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a18.48 18.48 0 0 1-2.68 3.4M6.53 6.98C3.86 8.76 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.8 9.8 0 0 0 4.14-.91" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs font-bold uppercase text-[#716a7c]">Available Balance</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-[#4b2673]">
                            <span x-show="showMoney" x-cloak>KES {{ number_format($balance, 2) }}</span>
                            <span x-show="! showMoney">KES ******</span>
                        </h2>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-md bg-[#f8f6f1] p-3">
                            <p class="text-xs font-bold uppercase text-[#716a7c]">Savings</p>
                            <p class="mt-1 text-sm font-extrabold text-[#241f2f]">
                                <span x-show="showMoney" x-cloak>KES {{ number_format($savings, 2) }}</span>
                                <span x-show="! showMoney">KES ******</span>
                            </p>
                        </div>
                        <div class="rounded-md bg-[#f8f6f1] p-3">
                            <p class="text-xs font-bold uppercase text-[#716a7c]">Loan Exposure</p>
                            <p class="mt-1 text-sm font-extrabold text-[#b33636]">
                                <span x-show="showMoney" x-cloak>KES {{ number_format($loanBalance, 2) }}</span>
                                <span x-show="! showMoney">KES ******</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <p class="text-sm text-[#716a7c]">Savings</p>
            <h3 class="mt-1 text-xl font-extrabold text-[#241f2f]">
                <span x-show="showMoney" x-cloak>KES {{ number_format($savings, 2) }}</span>
                <span x-show="! showMoney">KES ******</span>
            </h3>
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <p class="text-sm text-[#716a7c]">Active Loans</p>
            <h3 class="mt-1 text-xl font-extrabold text-[#241f2f]">
                {{ $activeLoans }}
            </h3>
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm text-[#716a7c]">Loan Exposure</p>
                <button type="button"
                    @click="showMoney = ! showMoney"
                    :aria-label="showMoney ? 'Hide loan exposure' : 'Show loan exposure'"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#ded8c8] text-[#4b2673] hover:bg-[#f6f1e6]">
                    <svg x-show="! showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5Z" />
                    </svg>
                    <svg x-show="showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2 2 0 0 0 13.4 13.4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.45A9.14 9.14 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a18.48 18.48 0 0 1-2.68 3.4M6.53 6.98C3.86 8.76 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.8 9.8 0 0 0 4.14-.91" />
                    </svg>
                </button>
            </div>
            <h3 class="mt-1 text-xl font-extrabold text-[#b33636]">
                <span x-show="showMoney" x-cloak>KES {{ number_format($loanBalance, 2) }}</span>
                <span x-show="! showMoney">KES ******</span>
            </h3>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-lg font-extrabold text-[#241f2f]">
                Recent Activity
            </h3>

            @forelse($transactions as $tx)
                <div class="flex items-center justify-between border-b py-2 last:border-none">
                    <div>
                        <p class="text-sm font-bold text-[#241f2f]">
                            {{ ucfirst($tx->type) }}
                        </p>
                        <p class="text-xs text-[#716a7c]">
                            {{ $tx->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="text-sm font-semibold {{ $tx->type == 'deposit' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $tx->type == 'deposit' ? '+' : '-' }}
                        KES {{ number_format($tx->amount, 2) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No transactions yet</p>
            @endforelse
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-lg font-extrabold text-[#241f2f]">
                Loans Overview
            </h3>

            @forelse($loans as $loan)
                <div class="mb-4">
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="text-[#5f5968]">
                            KES {{ number_format($loan->principal ?? $loan->amount ?? 0, 2) }}
                        </span>
                        <span class="rounded-full px-2 py-1 text-xs capitalize {{ $loan->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $loan->status }}
                        </span>
                    </div>

                    <div class="h-2 w-full rounded-full bg-[#eee8dc]">
                        <div class="h-2 rounded-full bg-[#4b2673]" style="width: {{ ($loan->total_payable ?? 0) > 0 ? max(5, min(100, (($loan->total_payable - $loan->balance) / $loan->total_payable) * 100)) : 5 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No loans yet</p>
            @endforelse
        </div>
    </div>

    <div class="flex flex-col gap-4 rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
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
               class="rounded-md bg-[#4b2673] px-4 py-2 text-sm font-bold text-white hover:bg-[#3d1d61]">
                Open Wallet
            </a>

            <a href="{{ route('loans.create') }}"
               class="rounded-md bg-[#f1cc4b] px-4 py-2 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">
                Apply Loan
            </a>
        </div>
    </div>

</div>
@endsection
