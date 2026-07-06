<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Transactions</h2>
            <a href="{{ route('transactions.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Post Transaction</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Date</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Account</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Type</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $transaction->transacted_at->format('M d, Y') }}</td>
                                <td class="px-5 py-4 text-sm text-gray-900 dark:text-white">{{ $transaction->member->full_name }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $transaction->account->account_no }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $transaction->type_label }}</td>
                                <td class="px-5 py-4 text-right text-sm font-semibold {{ $transaction->isDebit() ? 'text-red-600' : 'text-green-600' }}">{{ $transaction->isDebit() ? '-' : '+' }}{{ number_format($transaction->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">{{ $transactions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
