<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Royalty Sacco</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r hidden md:flex flex-col">

        <div class="p-6 text-xl font-bold text-indigo-600 border-b">
            👑 Royalty
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2 text-sm">

            @auth
                @php $user = auth()->user(); @endphp

                <!-- DASHBOARD -->
                <a href="{{ $user->is_admin ? route('admin.dashboard') : route('dashboard') }}"
                   class="block px-4 py-2 rounded-lg
                   {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') 
                        ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                        : 'text-gray-600 hover:bg-indigo-50' }}">
                    Dashboard
                </a>

                {{-- ================= ADMIN ONLY ================= --}}
                @if($user->is_admin)

                    <a href="{{ route('members.index') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->routeIs('members.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                        Members
                    </a>

                    <a href="{{ route('loans.index') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->routeIs('loans.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                        Loan Management
                    </a>

                    <a href="{{ route('loan-products.index') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->routeIs('loan-products.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                        Loan Products
                    </a>

                @endif


                {{-- ================= NORMAL USER ================= --}}
                @if(!$user->is_admin)

                    <a href="{{ route('wallet') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->routeIs('wallet') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                        My Wallet
                    </a>

                    <a href="{{ route('loans.index') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->routeIs('loans.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                        My Loans
                    </a>

                @endif

                <!-- TRANSACTIONS (ALL USERS) -->
                <a href="{{ route('transactions.index') }}"
                   class="block px-4 py-2 rounded-lg
                   {{ request()->routeIs('transactions.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-indigo-50' }}">
                    Transactions
                </a>

            @endauth

        </nav>

        <div class="p-4 border-t text-xs text-gray-400">
            © {{ date('Y') }} Royalty Sacco
        </div>

    </aside>


    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center">

            <h2 class="text-lg font-semibold text-gray-800">
                {{ $header ?? 'Dashboard' }}
            </h2>

            @auth
            <div class="flex items-center space-x-4">

                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">
                        Logout
                    </button>
                </form>

            </div>
            @endauth

        </header>

        <!-- CONTENT -->
        <main class="p-6 max-w-7xl mx-auto w-full">
            <div class="space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

</div>

</body>
</html>