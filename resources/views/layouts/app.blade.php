<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Royalty Sacco</title>

    -- @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md hidden md:flex flex-col">

            <div class="p-6 text-xl font-bold text-indigo-600">
                👑 Royalty
            </div>

            <nav class="flex-1 px-4 space-y-2">

                <a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-indigo-50">
                    Dashboard
                </a>

                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-indigo-50">
                    Members
                </a>

                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-indigo-50">
                    Loans
                </a>

                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-indigo-50">
                    Transactions
                </a>

            </nav>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">

                <h2 class="text-lg font-semibold text-gray-700">
                    {{ $header ?? 'Dashboard' }}
                </h2>

                <div class="text-sm text-gray-600">
                    {{ Auth::user()->name }}
                </div>

            </header>

            <!-- PAGE CONTENT -->
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>
</html>