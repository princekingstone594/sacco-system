<x-app-layout>
    <x-slot name="header">
        Dashboard
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
                <h2 class="text-2xl font-bold text-indigo-600 mt-2">1,245</h2>
            </div>

            <!-- TOTAL SAVINGS -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Savings</p>
                <h2 class="text-2xl font-bold text-green-600 mt-2">KES 4.2M</h2>
            </div>

            <!-- ACTIVE LOANS -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition">
                <p class="text-sm text-gray-500">Active Loans</p>
                <h2 class="text-2xl font-bold text-purple-600 mt-2">312</h2>
            </div>
        </div>

        <!-- SECOND ROW -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            <!-- RECENT ACTIVITY -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">Recent Activity</h3>

                <ul class="space-y-3 text-sm text-gray-600">
                    <li>💰 John deposited KES 5,000</li>
                    <li>📤 Mary withdrew KES 2,000</li>
                    <li>📄 Loan approved for Peter</li>
                </ul>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">Quick Actions</h3>

                <div class="grid grid-cols-2 gap-4">

                    <button class="bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                        + Add Member
                    </button>

                    <button class="bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                        + Record Savings
                    </button>

                    <button class="bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
                        + Issue Loan
                    </button>

                    <button class="bg-gray-800 text-white py-2 rounded-lg hover:bg-black transition">
                        Reports
                    </button>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>