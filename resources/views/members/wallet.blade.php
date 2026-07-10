<x-app-layout>
    <x-slot name="header">
        💼 Member Wallet
    </x-slot>

    <!-- MEMBER INFO -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            {{ $member->full_name }}
        </h2>
        <p class="text-gray-500">
            {{ $member->email }} • {{ $member->phone }}
        </p>
    </div>

    <!-- TOTAL BALANCE -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6 rounded-xl shadow mb-6">
        <p class="text-sm opacity-80">Total Savings</p>
        <h1 class="text-3xl font-bold mt-2">
            KES {{ number_format($totalBalance, 2) }}
        </h1>
    </div>

    <!-- ACCOUNTS -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
        <h3 class="text-lg font-semibold mb-4">Accounts</h3>

        <div class="grid md:grid-cols-2 gap-4">
            @foreach($member->accounts as $account)
                <div class="border rounded-lg p-4 hover:shadow transition">
                    <p class="text-sm text-gray-500">
                        {{ $account->account_no }}
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ ucfirst($account->type) }}
                    </p>

                    <p class="text-xl font-bold text-indigo-600 mt-2">
                        KES {{ number_format($account->balance, 2) }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- RECENT TRANSACTIONS -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h3 class="text-lg font-semibold mb-4">
            Recent Transactions
        </h3>

        <table class="w-full text-sm">
            <thead class="text-gray-500 border-b">
                <tr>
                    <th class="text-left py-2">Date</th>
                    <th class="text-left py-2">Account</th>
                    <th class="text-left py-2">Type</th>
                    <th class="text-right py-2">Amount</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $tx)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">
                            {{ $tx->transacted_at->format('d M Y') }}
                        </td>

                        <td>
                            {{ $tx->account->account_no }}
                        </td>

                        <td>
                            <span class="px-2 py-1 rounded text-xs
                                {{ $tx->type === 'deposit' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $tx->type === 'withdrawal' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ ucfirst($tx->type) }}
                            </span>
                        </td>

                        <td class="text-right font-semibold
                            {{ $tx->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $tx->type === 'deposit' ? '+' : '-' }}
                            {{ number_format($tx->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-400">
                            No transactions yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>