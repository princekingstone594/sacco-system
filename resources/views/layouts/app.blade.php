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

<body class="bg-[#f7f4ed] font-sans text-[#241f2f] antialiased">
@php
    $user = auth()->user();
    $isAdmin = (bool) optional($user)->is_admin;
    $avatarUrl = optional($user)->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : null;
    $navItems = [
        ['label' => 'Home', 'route' => $isAdmin ? 'admin.dashboard' : 'dashboard', 'active' => $isAdmin ? 'admin.dashboard' : 'dashboard'],
        ['label' => 'Wallet', 'route' => 'wallet.index', 'active' => 'wallet.*', 'member' => true],
        ['label' => 'Loans', 'route' => 'loans.index', 'active' => 'loans.*'],
        ['label' => 'Transactions', 'route' => 'transactions.index', 'active' => 'transactions.*'],
        ['label' => 'Customer Care', 'route' => 'customer-care.create', 'active' => 'customer-care.*', 'member' => true],
        ['label' => 'Staff', 'route' => 'members.index', 'active' => 'members.*', 'admin' => true],
        ['label' => 'Accounts', 'route' => 'accounts.index', 'active' => 'accounts.*', 'admin' => true],
        ['label' => 'Products', 'route' => 'loan-products.index', 'active' => 'loan-products.*', 'admin' => true],
        ['label' => 'Reports', 'route' => 'reports.index', 'active' => 'reports.*', 'admin' => true],
        ['label' => 'Enquiries', 'route' => 'admin.customer-care.index', 'active' => 'admin.customer-care.*', 'admin' => true],
    ];
@endphp

<div class="min-h-screen">
    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-[#e5decc] bg-white/90 shadow-sm backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex min-h-20 items-center justify-between gap-4 py-3">
                <a href="{{ route($isAdmin ? 'admin.dashboard' : 'dashboard') }}" class="flex min-w-0 items-center gap-3">
                    <x-application-logo class="h-12 w-12 shrink-0 rounded-lg object-contain" />
                    <div class="min-w-0">
                        <p class="truncate text-sm font-extrabold uppercase tracking-wide text-[#4b2673]">Royalty Sacco</p>
                        <p class="truncate text-xs font-semibold text-[#947b2f]">{{ $isAdmin ? 'Admin workspace' : 'Member growth portal' }}</p>
                    </div>
                </a>

                <div class="hidden items-center gap-3 lg:flex">
                    <div class="flex items-center gap-3 rounded-lg border border-[#e5decc] bg-[#fbfaf7] p-2">
                        <div class="h-11 w-11 overflow-hidden rounded-full bg-[#f6f1e6]">
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm font-extrabold text-[#4b2673]">
                                    {{ strtoupper(substr($user->name ?? 'R', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="max-w-36">
                            <p class="truncate text-sm font-extrabold text-[#241f2f]">{{ $user->name ?? 'Royalty User' }}</p>
                            <p class="text-xs font-semibold text-[#716a7c]">{{ $isAdmin ? 'Admin' : 'Member' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="rounded-md border border-[#ded8c8] px-3 py-2 text-sm font-bold text-[#4b2673] hover:bg-[#f6f1e6]">Profile</a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-[#241f2f] px-4 py-2 text-sm font-bold text-white hover:bg-[#3a314b]">Logout</button>
                    </form>
                </div>

                <button type="button" @click="open = ! open" class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-[#ded8c8] text-[#4b2673] lg:hidden">
                    <svg x-show="! open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="hidden items-center justify-center gap-1 border-t border-[#eee8dc] py-3 text-sm font-bold lg:flex">
                @foreach ($navItems as $item)
                    @continue(($item['admin'] ?? false) && ! $isAdmin)
                    @continue(($item['member'] ?? false) && $isAdmin)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-md px-4 py-2 transition {{ request()->routeIs($item['active']) ? 'bg-[#4b2673] text-white shadow-sm' : 'text-[#5f5968] hover:bg-[#f6f1e6] hover:text-[#4b2673]' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div x-show="open" x-transition class="border-t border-[#eee8dc] py-4 lg:hidden">
                <div class="mb-4 flex items-center gap-3 rounded-lg border border-[#e5decc] bg-[#fbfaf7] p-3">
                    <div class="h-12 w-12 overflow-hidden rounded-full bg-[#f6f1e6]">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-sm font-extrabold text-[#4b2673]">
                                {{ strtoupper(substr($user->name ?? 'R', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-extrabold text-[#241f2f]">{{ $user->name ?? 'Royalty User' }}</p>
                        <p class="text-xs font-semibold text-[#716a7c]">{{ $isAdmin ? 'Admin' : 'Member' }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="rounded-md border border-[#ded8c8] px-3 py-2 text-sm font-bold text-[#4b2673]">Profile</a>
                </div>

                <nav class="grid gap-2 text-sm font-bold sm:grid-cols-2">
                    @foreach ($navItems as $item)
                        @continue(($item['admin'] ?? false) && ! $isAdmin)
                        @continue(($item['member'] ?? false) && $isAdmin)
                        <a href="{{ route($item['route']) }}"
                           class="rounded-md px-3 py-2 {{ request()->routeIs($item['active']) ? 'bg-[#4b2673] text-white' : 'bg-[#f6f1e6] text-[#5f5968]' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-md bg-[#241f2f] px-4 py-2 text-sm font-bold text-white">Logout</button>
                </form>
            </div>
        </div>
    </header>

    @isset($header)
        <section class="border-b border-[#ded8c8] bg-white px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                {{ $header }}
            </div>
        </section>
    @endisset

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>
</div>
</body>
</html>
