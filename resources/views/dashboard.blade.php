<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">SACCO Dashboard</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Members, savings, shares, and loans at a glance.</p>
            </div>
            <a href="{{ route('members.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Register Member</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Members</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($memberCount) }}</p>
                    <p class="mt-1 text-sm text-green-600">{{ number_format($activeMemberCount) }} active</p>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Savings & Deposits</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalSavings, 2) }}</p>
                    <p class="mt-1 text-sm text-gray-500">Member funds held</p>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Share Capital</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalShares, 2) }}</p>
                    <p class="mt-1 text-sm text-gray-500">Total shares posted</p>
                </div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Loan Portfolio</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">{{ number_format($loanPortfolio, 2) }}</p>
                    <p class="mt-1 text-sm text-amber-600">{{ number_format($activeLoans) }} active loans</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-lg bg-white shadow-sm dark:bg-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                        <a href="{{ route('transactions.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Post transaction</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Member</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Type</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($recentTransactions as $transaction)
                                    <tr>
                                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $transaction->transacted_at->format('M d, Y') }}</td>
                                        <td class="px-5 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->member->full_name }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $transaction->type_label }}</td>
                                        <td class="px-5 py-3 text-right text-sm font-semibold {{ $transaction->isDebit() ? 'text-red-600' : 'text-green-600' }}">{{ $transaction->isDebit() ? '-' : '+' }}{{ number_format($transaction->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-gray-500">No transactions yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg bg-white shadow-sm dark:bg-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Recent Loans</h3>
                        <a href="{{ route('loans.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Issue loan</a>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($recentLoans as $loan)
                            <a href="{{ route('loans.show', $loan) }}" class="block p-5 hover:bg-gray-50 dark:hover:bg-gray-900">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $loan->loan_no }}</p>
                                        <p class="text-sm text-gray-500">{{ $loan->member->full_name }} · {{ $loan->product->name }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($loan->balance, 2) }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="p-5 text-sm text-gray-500">No loans issued yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
