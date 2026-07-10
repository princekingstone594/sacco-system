<x-app-layout>
    <x-slot name="header">
        📊 Dashboard
    </x-slot>

    <div class="min-h-screen bg-gray-100 p-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                👑 Royalty Sacco Dashboard
            </h1>

            <div class="text-sm text-gray-500">
                Welcome back, {{ Auth::user()->name }}
            </div>
        </div>

        <!-- STATS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- TOTAL MEMBERS -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Members</p>
                <h2 class="text-2xl font-bold text-indigo-600 mt-2">
                    {{ $membersCount ?? 0 }}
                </h2>
            </div>

            <!-- TOTAL SAVINGS -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Savings</p>
                <h2 class="text-2xl font-bold text-green-600 mt-2">
                    KES {{ number_format($totalSavings ?? 0) }}
                </h2>
            </div>

            <!-- ACTIVE LOANS -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Active Loans</p>
                <h2 class="text-2xl font-bold text-purple-600 mt-2">
                    {{ $activeLoans ?? 0 }}
                </h2>
            </div>
        </div>

        <!-- SECOND ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

            <!-- CHART -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Savings Overview
                </h3>

                <canvas id="savingsChart"></canvas>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Quick Actions
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <a href="{{ route('members.create') }}"
                       class="bg-indigo-600 text-white py-2 rounded-lg text-center hover:bg-indigo-700 transition">
                        + Add Member
                    </a>

                    <a href="{{ route('savings.create') }}"
                       class="bg-green-600 text-white py-2 rounded-lg text-center hover:bg-green-700 transition">
                        + Record Savings
                    </a>

                    <a href="{{ route('loans.create') }}"
                       class="bg-purple-600 text-white py-2 rounded-lg text-center hover:bg-purple-700 transition">
                        + Issue Loan
                    </a>

                    <a href="#"
                       class="bg-gray-800 text-white py-2 rounded-lg text-center hover:bg-black transition">
                        Reports
                    </a>

                </div>
            </div>
        </div>

        <!-- THIRD ROW -->
        <div class="mt-6">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Recent Activity
                </h3>

                <ul class="space-y-3 text-sm text-gray-600">
                    @forelse($recentActivities ?? [] as $activity)
                        <li>
                            💰 {{ $activity->member->name ?? 'Member' }}
                            deposited KES {{ number_format($activity->amount) }}
                        </li>
                    @empty
                        <li>No recent activity</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

    <!-- CHART SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('savingsChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months ?? []) !!},
                datasets: [{
                    label: 'Monthly Savings',
                    data: {!! json_encode($monthlySavings ?? []) !!},
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>

</x-app-layout>