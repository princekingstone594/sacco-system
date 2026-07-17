<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Royalty Sacco</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-950 text-white antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col">

        <!-- LOGO -->
        <div class="p-6 text-xl font-bold border-b border-gray-800">
            👑 Royalty Sacco
        </div>

        <!-- NAV -->
        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                📊 Dashboard
            </a>

            <a href="{{ route('wallet.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                💼 Wallet
            </a>

            <a href="{{ route('loans.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                💳 Loans
            </a>

            <a href="{{ route('transactions.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                🧾 Transactions
            </a>

            <a href="{{ route('reports.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                📈 Reports
            </a>

        </nav>

        <!-- USER -->
        <div class="p-4 border-t border-gray-800 text-sm">
            <div class="mb-2">
                {{ auth()->user()->name ?? 'User' }}
            </div>

            <!-- ✅ LOGOUT (FIXED) -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    🚪 Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

</body>
</html>