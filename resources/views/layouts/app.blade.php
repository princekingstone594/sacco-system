<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Royalty Sacco</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d4ed8',
                    }
                }
            }
        }
    </script>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r hidden md:flex flex-col">

        <!-- LOGO -->
        <div class="p-6 text-xl font-bold text-indigo-600 border-b">
            👑 Royalty
        </div>

        <!-- NAV -->
        <nav class="flex-1 px-4 py-4 space-y-2 text-sm">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('dashboard') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                    : 'text-gray-600 hover:bg-indigo-50' }}">
                Dashboard
            </a>

            <!-- Members -->
            <a href="{{ route('members.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('members.*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                    : 'text-gray-600 hover:bg-indigo-50' }}">
                Members
            </a>

            <!-- Loans -->
            <a href="{{ route('loans.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('loans.*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                    : 'text-gray-600 hover:bg-indigo-50' }}">
                Loans
            </a>

            <!-- Transactions -->
            <a href="{{ route('transactions.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ request()->routeIs('transactions.*') 
                    ? 'bg-indigo-100 text-indigo-700 font-semibold' 
                    : 'text-gray-600 hover:bg-indigo-50' }}">
                Transactions
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-4 border-t text-xs text-gray-400">
            © {{ date('Y') }} Royalty Sacco
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center">

            <h2 class="text-lg font-semibold text-gray-800">
                {{ $header ?? 'Dashboard' }}
            </h2>

            <div class="flex items-center space-x-4">

                <span class="text-sm text-gray-600">
                    {{ Auth::user()->name }}
                </span>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">
                        Logout
                    </button>
                </form>

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="p-6 max-w-7xl mx-auto w-full">

            <!-- GLOBAL PAGE WRAPPER -->
            <div class="space-y-6">
                {{ $slot }}
            </div>

        </main>

    </div>

</div>

</body>
</html>