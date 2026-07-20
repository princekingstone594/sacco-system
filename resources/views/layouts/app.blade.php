<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Royalty Sacco') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
</head>

<body class="bg-[#f6f4ef] font-sans text-[#241f2f] antialiased">
@php
    $user = auth()->user();
    $isAdmin = (bool) optional($user)->is_admin;
    $navItems = [
        ['label' => 'Overview', 'route' => $isAdmin ? 'admin.dashboard' : 'dashboard', 'active' => $isAdmin ? 'admin.dashboard' : 'dashboard'],
        ['label' => 'Members', 'route' => 'members.index', 'active' => 'members.*', 'admin' => true],
        ['label' => 'Accounts', 'route' => 'accounts.index', 'active' => 'accounts.*', 'admin' => true],
        ['label' => 'Wallet', 'route' => 'wallet.index', 'active' => 'wallet.*', 'member' => true],
        ['label' => 'Loans', 'route' => 'loans.index', 'active' => 'loans.*'],
        ['label' => 'Loan Products', 'route' => 'loan-products.index', 'active' => 'loan-products.*', 'admin' => true],
        ['label' => 'Transactions', 'route' => 'transactions.index', 'active' => 'transactions.*'],
        ['label' => 'Reports', 'route' => 'reports.index', 'active' => 'reports.*', 'admin' => true],
        ['label' => 'Customer Care', 'route' => 'customer-care.create', 'active' => 'customer-care.*', 'member' => true],
        ['label' => 'Enquiries', 'route' => 'admin.customer-care.index', 'active' => 'admin.customer-care.*', 'admin' => true],
    ];
@endphp

<div class="min-h-screen lg:flex">
    <aside class="hidden w-72 shrink-0 border-r border-[#ded8c8] bg-white lg:flex lg:flex-col">
        <a href="{{ route($isAdmin ? 'admin.dashboard' : 'dashboard') }}" class="flex items-center gap-3 border-b border-[#eee8dc] px-6 py-5">
            <x-application-logo class="h-12 w-12 rounded-lg object-contain" />
            <div>
                <p class="text-sm font-extrabold uppercase text-[#4b2673]">Royalty Sacco</p>
                <p class="text-xs font-medium text-[#947b2f]">Empowering Destinies</p>
            </div>
        </a>

        <nav class="flex-1 space-y-1 px-4 py-5 text-sm font-semibold">
            @foreach ($navItems as $item)
                @continue(($item['admin'] ?? false) && ! $isAdmin)
                @continue(($item['member'] ?? false) && $isAdmin)
                <a href="{{ route($item['route']) }}"
                   class="block rounded-md px-4 py-3 transition {{ request()->routeIs($item['active']) ? 'bg-[#4b2673] text-white shadow-sm' : 'text-[#5f5968] hover:bg-[#f6f1e6] hover:text-[#4b2673]' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="border-t border-[#eee8dc] p-4">
            <div class="mb-3 rounded-md bg-[#f8f6f1] p-3">
                <p class="text-sm font-bold text-[#241f2f]">{{ $user->name ?? 'Royalty User' }}</p>
                <p class="truncate text-xs text-[#716a7c]">{{ $user->email ?? '' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm font-semibold">
                <a href="{{ route('profile.edit') }}" class="rounded-md border border-[#ded8c8] px-3 py-2 text-center text-[#4b2673] hover:bg-[#f6f1e6]">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-md bg-[#241f2f] px-3 py-2 text-white hover:bg-[#3a314b]">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="min-w-0 flex-1">
        <header class="border-b border-[#ded8c8] bg-white/95 px-4 py-4 backdrop-blur lg:hidden">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route($isAdmin ? 'admin.dashboard' : 'dashboard') }}" class="flex items-center gap-3">
                    <x-application-logo class="h-11 w-11 rounded-lg object-contain" />
                    <div>
                        <p class="text-sm font-extrabold uppercase text-[#4b2673]">Royalty Sacco</p>
                        <p class="text-xs text-[#947b2f]">{{ $isAdmin ? 'Admin workspace' : 'Member portal' }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md bg-[#241f2f] px-3 py-2 text-sm font-semibold text-white">Logout</button>
                </form>
            </div>
            <nav class="mt-4 flex gap-2 overflow-x-auto pb-1 text-sm font-semibold">
                @foreach ($navItems as $item)
                    @continue(($item['admin'] ?? false) && ! $isAdmin)
                    @continue(($item['member'] ?? false) && $isAdmin)
                    <a href="{{ route($item['route']) }}"
                       class="shrink-0 rounded-md px-3 py-2 {{ request()->routeIs($item['active']) ? 'bg-[#4b2673] text-white' : 'bg-[#f6f1e6] text-[#5f5968]' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </header>

        @isset($header)
            <div class="border-b border-[#ded8c8] bg-white px-6 py-5">
                <div class="mx-auto max-w-7xl">
                    {{ $header }}
                </div>
            </div>
        @endisset

        <main class="mx-auto min-h-screen max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>
</body>
</html>
