@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-lg bg-[#241f2f] p-6 text-white shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-bold uppercase text-[#f1cc4b]">Admin workspace</p>
                <h1 class="mt-2 text-3xl font-extrabold">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-white/75">
                    Monitor members, savings, loan exposure, and Sacco operations from one control room.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('members.create') }}" class="rounded-md bg-[#f1cc4b] px-4 py-2 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">Add Member</a>
                <a href="{{ route('loan-products.index') }}" class="rounded-md border border-white/20 px-4 py-2 text-sm font-bold text-white hover:bg-white/10">Loan Products</a>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Total Members', 'value' => number_format($membersCount ?? 0), 'tone' => 'text-[#4b2673]'],
            ['label' => 'Total Savings', 'value' => 'KES ' . number_format($totalSavings ?? 0), 'tone' => 'text-[#0f7a55]'],
            ['label' => 'Active Loans', 'value' => number_format($activeLoans ?? 0), 'tone' => 'text-[#4b2673]'],
            ['label' => 'Pending Loans', 'value' => number_format($pendingLoans ?? 0), 'tone' => 'text-[#a88624]'],
        ] as $stat)
            <article class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
                <p class="text-xs font-bold uppercase text-[#716a7c]">{{ $stat['label'] }}</p>
                <p class="mt-3 text-2xl font-extrabold {{ $stat['tone'] }}">{{ $stat['value'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-[#241f2f]">Operational Shortcuts</h2>
                    <p class="mt-1 text-sm text-[#716a7c]">Fast paths for the current foundation phase.</p>
                </div>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('members.index') }}" class="rounded-md bg-[#f6f1e6] px-4 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#eee3cd]">Manage Members</a>
                <a href="{{ route('accounts.index') }}" class="rounded-md bg-[#f6f1e6] px-4 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#eee3cd]">Review Accounts</a>
                <a href="{{ route('loans.index') }}" class="rounded-md bg-[#f6f1e6] px-4 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#eee3cd]">Loan Pipeline</a>
                <a href="{{ route('reports.index') }}" class="rounded-md bg-[#f6f1e6] px-4 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#eee3cd]">Reports</a>
                <a href="{{ route('admin.customer-care.index') }}" class="rounded-md bg-[#f6f1e6] px-4 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#eee3cd]">Customer Enquiries</a>
            </div>
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-[#241f2f]">Recent Transactions</h2>
                    <p class="mt-1 text-sm text-[#716a7c]">Latest financial movements in the Sacco ledger.</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="text-sm font-bold text-[#4b2673] hover:underline">View all</a>
            </div>

            <div class="mt-5 divide-y divide-[#eee8dc]">
                @forelse ($recentTransactions ?? [] as $transaction)
                    <div class="flex items-center justify-between gap-4 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-[#241f2f]">
                                {{ $transaction->account->member->name ?? 'Member account' }}
                            </p>
                            <p class="text-xs capitalize text-[#716a7c]">
                                {{ $transaction->type }} by {{ $transaction->postedBy->name ?? 'System' }}
                            </p>
                        </div>
                        <p class="shrink-0 text-sm font-extrabold {{ $transaction->type === 'deposit' ? 'text-[#0f7a55]' : 'text-[#b33636]' }}">
                            KES {{ number_format($transaction->amount, 2) }}
                        </p>
                    </div>
                @empty
                    <p class="py-6 text-sm text-[#716a7c]">No transactions have been posted yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
        <h2 class="text-lg font-extrabold text-[#241f2f]">Recommended Next Sprint</h2>
        <div class="mt-4 grid gap-3 md:grid-cols-3">
            <div class="rounded-md bg-[#f8f6f1] p-4">
                <p class="text-sm font-bold text-[#4b2673]">Ledger reliability</p>
                <p class="mt-2 text-sm leading-6 text-[#716a7c]">Lock transaction posting rules, balance updates, reversals, and audit evidence.</p>
            </div>
            <div class="rounded-md bg-[#f8f6f1] p-4">
                <p class="text-sm font-bold text-[#4b2673]">Loan lifecycle</p>
                <p class="mt-2 text-sm leading-6 text-[#716a7c]">Finish approvals, repayment schedules, arrears, penalties, and member-facing status.</p>
            </div>
            <div class="rounded-md bg-[#f8f6f1] p-4">
                <p class="text-sm font-bold text-[#4b2673]">Compliance layer</p>
                <p class="mt-2 text-sm leading-6 text-[#716a7c]">Add 2FA, permission policies, audit filters, exports, and stronger report validation.</p>
            </div>
        </div>
    </section>
</div>
@endsection
