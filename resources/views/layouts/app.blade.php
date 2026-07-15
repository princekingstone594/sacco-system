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
    <aside class="w-64 bg-black/40 backdrop-blur-xl border-r border-white/10 hidden md:flex flex-col">

        <!-- LOGO -->
        <div class="p-6 text-xl font-bold text-indigo-400 border-b border-white/10">
            👑 Royalty
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2 text-sm">

            @auth
                @php $user = auth()->user(); @endphp

                <!-- DASHBOARD -->
                <a href="{{ $user->is_admin ? route('admin.dashboard') : route('dashboard') }}"
                   class="block px-4 py-2 rounded-xl
                   {{ request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') 
                        ? 'bg-indigo-500/20 text-indigo-300' 
                        : 'text-gray-300 hover:bg-white/10' }}">
                    Dashboard
                </a>

                {{-- ================= ADMIN ================= --}}
                @if($user->is_admin)

                    <a href="{{ route('members.index') }}"
                       class="block px-4 py-2 rounded-xl
                       {{ request()->routeIs('members.*') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                        Members
                    </a>

                    <a href="{{ route('admin.loans.index') }}"
                       class="block px-4 py-2 rounded-xl
                       {{ request()->routeIs('admin.loans.*') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                        Loan Management
                    </a>

                    <a href="{{ route('loan-products.index') }}"
                       class="block px-4 py-2 rounded-xl
                       {{ request()->routeIs('loan-products.*') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                        Loan Products
                    </a>

                @endif

                {{-- ================= USER ================= --}}
                @if(!$user->is_admin)

                    <a href="{{ route('wallet') }}"
                       class="block px-4 py-2 rounded-xl
                       {{ request()->routeIs('wallet') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                        Wallet
                    </a>

                    <a href="{{ route('loans.my') }}"
                       class="block px-4 py-2 rounded-xl
                       {{ request()->routeIs('loans.my') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                        My Loans
                    </a>

                @endif

                <!-- TRANSACTIONS -->
                <a href="{{ route('transactions.index') }}"
                   class="block px-4 py-2 rounded-xl
                   {{ request()->routeIs('transactions.*') ? 'bg-indigo-500/20 text-indigo-300' : 'text-gray-300 hover:bg-white/10' }}">
                    Transactions
                </a>

            @endauth

        </nav>
    </aside>


    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="bg-black/40 backdrop-blur-xl border-b border-white/10 px-6 py-4 flex justify-between items-center">
            <div class="text-lg font-semibold text-white">
                @yield('header', 'Dashboard')
            </div>

            @auth
            <div class="flex items-center gap-4 text-sm text-gray-300">
                <span>{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-400 hover:underline">Logout</button>
                </form>
            </div>
            @endauth
        </header>

        <!-- CONTENT -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>