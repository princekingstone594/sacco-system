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
    <aside class="w-64 bg-gray-900 border-r border-gray-800 hidden md:flex flex-col">
        <div class="p-6 text-xl font-bold">
            👑 Royalty
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800">Dashboard</a>
            <a href="{{ route('wallet') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800">Wallet</a>
            <a href="{{ route('loans.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-800">Loans</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOP NAVBAR -->
        <header class="bg-gray-900 border-b border-gray-800 px-6 py-4 flex justify-between items-center">

            <!-- LEFT -->
            <div>
                <h1 class="text-lg font-semibold">
                    @yield('header', 'Dashboard')
                </h1>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">

                <!-- 🔔 NOTIFICATIONS -->
                <div x-data="{ open: false }" class="relative">

                    <!-- Bell -->
                    <button @click="open = !open" class="relative focus:outline-none">
                        🔔

                        <!-- Badge -->
                        @php
                            $count = auth()->user()->unreadNotifications->count();
                        @endphp

                        @if($count > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-xs px-1.5 rounded-full">
                                {{ $count }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open"
                         @click.outside="open = false"
                         class="absolute right-0 mt-3 w-80 bg-gray-900 border border-gray-800 rounded-xl shadow-xl p-4 z-50">

                        <h3 class="text-sm font-semibold mb-3">Notifications</h3>

                        <div class="space-y-3 max-h-80 overflow-y-auto">

                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                <div class="p-3 rounded-lg bg-gray-800 text-sm">
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-sm">No notifications</p>
                            @endforelse

                        </div>

                        <form method="POST" action="{{ route('notifications.read') }}">
                            @csrf
                            <button class="mt-3 text-xs text-indigo-400 hover:underline">
                                Mark all as read
                            </button>
                        </form>

                    </div>
                </div>

                <!-- USER -->
                <div class="text-sm">
                    {{ auth()->user()->name }}
                </div>

            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>