<x-app-layout>

    <x-slot name="header">
        My Wallet
    </x-slot>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Wallet Balance</p>
            <h2 class="text-2xl font-bold text-indigo-600">
                KES {{ number_format($balance, 2) }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Savings</p>
            <h2 class="text-2xl font-bold">
                KES {{ number_format($savings, 2) }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Active Loans</p>
            <h2 class="text-2xl font-bold text-red-500">
                {{ $loans->count() }}
            </h2>
        </div>

    </div>


    <!-- CHART -->
    <div class="bg-white p-6 rounded-xl shadow mt-6">
        <h3 class="text-lg font-semibold mb-4">Financial Overview</h3>

        <canvas id="walletChart" height="100"></canvas>
    </div>


    <!-- RECENT TRANSACTIONS -->
    <div class="bg-white p-6 rounded-xl shadow mt-6">

        <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-2">Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transactions as $tx)
                    <tr class="border-b">
                        <td class="py-2">{{ $tx->type }}</td>
                        <td>KES {{ number_format($tx->amount, 2) }}</td>
                        <td>{{ $tx->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-400">
                            No transactions yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>


    <!-- CHART SCRIPT -->
    <script>
        const ctx = document.getElementById('walletChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Savings', 'Loans'],
                datasets: [{
                    label: 'KES',
                    data: [
                        {{ $savings }},
                        {{ $loans->sum('amount') }}
                    ],
                    backgroundColor: [
                        '#4f46e5',
                        '#ef4444'
                    ]
                }]
            }
        });
    </script>

</x-app-layout>