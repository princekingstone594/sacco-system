@extends('layouts.app')

@section('header', '📊 Admin Dashboard')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white p-6">

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- 🔥 HEADER -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">👑 Royalty Sacco</h1>
                <p class="text-gray-400 text-sm">
                    Welcome back, {{ auth()->user()->name }}
                </p>
            </div>
        </div>

        <!-- 💎 STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-gray-400 text-xs">Total Members</p>
                <h2 class="text-xl font-bold text-indigo-400 mt-1">
                    {{ $membersCount ?? 0 }}
                </h2>
            </div>

            <div class="bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-gray-400 text-xs">Total Savings</p>
                <h2 class="text-xl font-bold text-green-400 mt-1">
                    KES {{ number_format($totalSavings ?? 0) }}
                </h2>
            </div>

            <div class="bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-gray-400 text-xs">Active Loans</p>
                <h2 class="text-xl font-bold text-purple-400 mt-1">
                    {{ $activeLoans ?? 0 }}
                </h2>
            </div>

        </div>

        <!-- 📊 SECOND ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- 📈 CHART -->
            <div class="bg-gray-800 p-5 rounded-xl shadow">
                <h3 class="text-sm text-gray-400 mb-3">
                    Savings Overview
                </h3>

                <canvas id="savingsChart"></canvas>

                @if(empty($months))
                    <p class="text-gray-500 text-xs mt-3">No chart data available</p>
                @endif
            </div>

            <!-- ⚡ QUICK ACTIONS (ADMIN ONLY) -->
            @auth
            @if(auth()->user()->is_admin)
            <div class="bg-gray-800 p-5 rounded-xl shadow">
                <h3 class="text-sm text-gray-400 mb-3">
                    Quick Actions
                </h3>

                <div class="grid grid-cols-2 gap-3 text-sm">

                    <a href="{{ route('members.create') }}"
                       class="bg-indigo-500 py-2 rounded-lg text-center hover:scale-105 transition">
                        + Member
                    </a>

                    <a href="{{ route('savings.create') }}"
                       class="bg-green-500 py-2 rounded-lg text-center hover:scale-105 transition">
                        + Savings
                    </a>

                    <a href="{{ route('loans.create') }}"
                       class="bg-purple-500 py-2 rounded-lg text-center hover:scale-105 transition">
                        + Loan
                    </a>

                    <a href="#"
                       class="bg-gray-700 py-2 rounded-lg text-center hover:bg-gray-600 transition">
                        Reports
                    </a>

                </div>
            </div>
            @endif
            @endauth

        </div>

        <!-- 📜 RECENT ACTIVITY -->
        <div class="bg-gray-800 p-5 rounded-xl shadow">
            <h3 class="text-sm text-gray-400 mb-3">
                Recent Activity
            </h3>

            <div class="space-y-3 text-sm">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex justify-between bg-gray-900 p-3 rounded-lg">
                        <div>
                            <p class="font-medium">
                                {{ $activity->member->name ?? 'Member' }}
                            </p>
                            <p class="text-xs text-gray-400 capitalize">
                                {{ $activity->type }}
                            </p>
                        </div>

                        <p class="text-green-400 font-semibold">
                            KES {{ number_format($activity->amount) }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-400">No recent activity</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- 📊 CHART SAFE INIT -->
<script>
    const ctx = document.getElementById('savingsChart');

    if (ctx && typeof Chart !== 'undefined') {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months ?? []) !!},
                datasets: [{
                    label: 'Monthly Savings',
                    data: {!! json_encode($monthlySavings ?? []) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.1)',
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
    }
</script>

@endsection