<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white">Transactions</h2>

            <a href="{{ route('transactions.create') }}"
               class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm shadow hover:opacity-90 transition">
                + New Transaction
            </a>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        <!-- FILTER BAR -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl p-4">
            <form method="GET" class="flex flex-wrap gap-3">

                <select name="type"
                    class="bg-white/10 border border-white/20 text-white rounded-xl px-3 py-2 text-sm">
                    <option value="">All Types</option>
                    <option value="deposit" @selected(request('type') == 'deposit')>Deposit</option>
                    <option value="withdrawal" @selected(request('type') == 'withdrawal')>Withdraw</option>
                    <option value="loan" @selected(request('type') == 'loan')>Loan</option>
                </select>

                <select name="date"
                    class="bg-white/10 border border-white/20 text-white rounded-xl px-3 py-2 text-sm">
                    <option value="">Any Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>

                <button class="px-4 py-2 bg-indigo-500 rounded-xl text-white text-sm">
                    Filter
                </button>
            </form>
        </div>

        <!-- TRANSACTIONS TABLE -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-white">

                <!-- HEADER -->
                <thead class="bg-white/5 text-gray-300 text-xs uppercase">
                    <tr>
                        <th class="p-4">Reference</th>
                        <th class="p-4">Member</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-white/10">

                    @forelse($transactions as $tx)
                        <tr class="hover:bg-white/5 transition">

                            <!-- REF -->
                            <td class="p-4 font-medium">
                                {{ $tx->reference ?? 'TXN-' . $tx->id }}
                            </td>

                            <!-- MEMBER -->
                            <td class="p-4 text-gray-300">
                                {{ $tx->member->full_name ?? 'N/A' }}
                            </td>

                            <!-- TYPE -->
                            <td class="p-4">
                                @if($tx->type === 'deposit')
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400">
                                        Deposit
                                    </span>
                                @elseif($tx->type === 'withdrawal')
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-500/20 text-red-400">
                                        Withdraw
                                    </span>
                                @elseif($tx->type === 'loan')
                                    <span class="px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400">
                                        Loan
                                    </span>
                                @endif
                            </td>

                            <!-- AMOUNT -->
                            <td class="p-4 font-semibold">
                                KES {{ number_format($tx->amount, 2) }}
                            </td>

                            <!-- DATE -->
                            <td class="p-4 text-gray-400">
                                {{ optional($tx->transacted_at)->format('M d, Y H:i') }}
                            </td>

                            <!-- ACTION -->
                            <td class="p-4 text-right">
                                <a href="{{ route('transactions.show', $tx) }}"
                                   class="text-indigo-400 hover:underline text-sm">
                                    View
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">
                                No transactions found
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-white/10">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>
</x-app-layout>