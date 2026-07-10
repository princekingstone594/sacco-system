<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Transactions</h2>

            <a href="{{ route('transactions.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                Post Transaction
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">

        <!-- FILTER -->
        <form method="GET" class="flex gap-2">
            <select name="type" class="rounded-md border-gray-300">
                <option value="">All Types</option>
                <option value="deposit" @selected(request('type')=='deposit')>Deposits</option>
                <option value="withdrawal" @selected(request('type')=='withdrawal')>Withdrawals</option>
                <option value="fee" @selected(request('type')=='fee')>Fees</option>
            </select>

            <button class="bg-gray-800 text-white px-3 py-1 rounded">
                Filter
            </button>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left">Date</th>
                        <th class="p-4 text-left">Member</th>
                        <th class="p-4 text-left">Account</th>
                        <th class="p-4 text-left">Type</th>
                        <th class="p-4 text-right">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr class="border-t">
                            <td class="p-4">{{ $transaction->transacted_at->format('M d, Y') }}</td>
                            <td class="p-4">{{ $transaction->member->full_name }}</td>
                            <td class="p-4">{{ $transaction->account->account_no }}</td>
                            <td class="p-4">{{ $transaction->type_label }}</td>
                            <td class="p-4 text-right font-semibold
                                {{ $transaction->isDebit() ? 'text-red-600' : 'text-green-600' }}">
                                {{ $transaction->isDebit() ? '-' : '+' }}
                                {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No transactions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="p-4 border-t">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>
</x-app-layout>