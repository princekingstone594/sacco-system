@extends('layouts.app')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

@php
    $dashboardUser = auth()->user();
@endphp

<div class="space-y-8" x-data="{ showMoney: false, showPortfolioModal: {{ $errors->hasAny(['name', 'category', 'target_amount', 'target_date', 'description']) ? 'true' : 'false' }} }">

    <section class="relative overflow-hidden rounded-lg bg-[#241f2f] text-white shadow-sm">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=1800&q=85" alt="Savings growth" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-[#241f2f]/75"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#241f2f] via-[#241f2f]/88 to-[#241f2f]/35"></div>
        </div>

        <div class="relative grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr_0.9fr] lg:p-10">
            <div class="flex min-h-[360px] flex-col justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-wide text-[#f1cc4b]">Royalty Sacco</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">
                        Empowering Destinies.
                    </h1>
                    <p class="mt-3 max-w-2xl text-2xl font-bold leading-snug text-white/90 sm:text-3xl">
                        Build Generational Wealth with us
                    </p>
                    <p class="mt-5 max-w-2xl text-base italic leading-7 text-white/80">
                        "Cast your bread upon the waters, For you will find it after many days" - Ecc 11:1
                    </p>
                    <p class="mt-5 max-w-2xl text-sm leading-7 text-white/75">
                        Welcome back, {{ $dashboardUser->name }}. Explore who we are, why we exist, and the saving portfolios that help you reach your goals — all from your Sacco home.
                    </p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#about-us" class="rounded-md bg-[#f1cc4b] px-5 py-3 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">About Us</a>
                    <a href="#our-products" class="rounded-md border border-white/25 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Our Products</a>
                    <a href="{{ route('customer-care.create') }}" class="rounded-md border border-white/25 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Ask Customer Care</a>
                </div>
            </div>

            <div class="flex flex-col justify-end">
                <div class="rounded-lg border border-white/15 bg-white/95 p-5 text-[#241f2f] shadow-sm backdrop-blur">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-14 w-14 overflow-hidden rounded-full bg-[#f6f1e6]">
                                @if ($dashboardUser->profile_photo_path)
                                    <img src="{{ asset('storage/'.$dashboardUser->profile_photo_path) }}" alt="{{ $dashboardUser->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xl font-extrabold text-[#4b2673]">
                                        {{ strtoupper(substr($dashboardUser->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-extrabold">{{ $dashboardUser->name }}</p>
                                <p class="text-xs font-semibold text-[#716a7c]">Member account</p>
                            </div>
                        </div>
                        <button type="button"
                            @click="showMoney = ! showMoney"
                            :aria-label="showMoney ? 'Hide balances' : 'Show balances'"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-[#ded8c8] text-[#4b2673] hover:bg-[#f6f1e6]">
                            <svg x-show="! showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5Z" />
                            </svg>
                            <svg x-show="showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2 2 0 0 0 13.4 13.4" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.45A9.14 9.14 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a18.48 18.48 0 0 1-2.68 3.4M6.53 6.98C3.86 8.76 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.8 9.8 0 0 0 4.14-.91" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs font-bold uppercase text-[#716a7c]">Available Balance</p>
                        <h2 class="mt-2 text-3xl font-extrabold text-[#4b2673]">
                            <span x-show="showMoney" x-cloak>KES {{ number_format($balance, 2) }}</span>
                            <span x-show="! showMoney">KES ******</span>
                        </h2>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-md bg-[#f8f6f1] p-3">
                            <p class="text-xs font-bold uppercase text-[#716a7c]">Savings</p>
                            <p class="mt-1 text-sm font-extrabold text-[#241f2f]">
                                <span x-show="showMoney" x-cloak>KES {{ number_format($savings, 2) }}</span>
                                <span x-show="! showMoney">KES ******</span>
                            </p>
                        </div>
                        <div class="rounded-md bg-[#f8f6f1] p-3">
                            <p class="text-xs font-bold uppercase text-[#716a7c]">Loan Exposure</p>
                            <p class="mt-1 text-sm font-extrabold text-[#b33636]">
                                <span x-show="showMoney" x-cloak>KES {{ number_format($loanBalance, 2) }}</span>
                                <span x-show="! showMoney">KES ******</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <p class="text-sm text-[#716a7c]">Savings</p>
            <h3 class="mt-1 text-xl font-extrabold text-[#241f2f]">
                <span x-show="showMoney" x-cloak>KES {{ number_format($savings, 2) }}</span>
                <span x-show="! showMoney">KES ******</span>
            </h3>
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <p class="text-sm text-[#716a7c]">Active Loans</p>
            <h3 class="mt-1 text-xl font-extrabold text-[#241f2f]">
                {{ $activeLoans }}
            </h3>
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm text-[#716a7c]">Loan Exposure</p>
                <button type="button"
                    @click="showMoney = ! showMoney"
                    :aria-label="showMoney ? 'Hide loan exposure' : 'Show loan exposure'"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-[#ded8c8] text-[#4b2673] hover:bg-[#f6f1e6]">
                    <svg x-show="! showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5Z" />
                    </svg>
                    <svg x-show="showMoney" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A2 2 0 0 0 13.4 13.4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.45A9.14 9.14 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a18.48 18.48 0 0 1-2.68 3.4M6.53 6.98C3.86 8.76 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.8 9.8 0 0 0 4.14-.91" />
                    </svg>
                </button>
            </div>
            <h3 class="mt-1 text-xl font-extrabold text-[#b33636]">
                <span x-show="showMoney" x-cloak>KES {{ number_format($loanBalance, 2) }}</span>
                <span x-show="! showMoney">KES ******</span>
            </h3>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-lg font-extrabold text-[#241f2f]">
                Recent Activity
            </h3>

            @forelse($transactions as $tx)
                <div class="flex items-center justify-between border-b py-2 last:border-none">
                    <div>
                        <p class="text-sm font-bold text-[#241f2f]">
                            {{ ucfirst($tx->type) }}
                        </p>
                        <p class="text-xs text-[#716a7c]">
                            {{ $tx->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="text-sm font-semibold {{ $tx->type == 'deposit' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $tx->type == 'deposit' ? '+' : '-' }}
                        KES {{ number_format($tx->amount, 2) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No transactions yet</p>
            @endforelse
        </div>

        <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-lg font-extrabold text-[#241f2f]">
                Loans Overview
            </h3>

            @forelse($loans as $loan)
                <div class="mb-4">
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="text-[#5f5968]">
                            KES {{ number_format($loan->principal ?? $loan->amount ?? 0, 2) }}
                        </span>
                        <span class="rounded-full px-2 py-1 text-xs capitalize {{ $loan->status == 'approved' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $loan->status }}
                        </span>
                    </div>

                    <div class="h-2 w-full rounded-full bg-[#eee8dc]">
                        <div class="h-2 rounded-full bg-[#4b2673]" style="width: {{ ($loan->total_payable ?? 0) > 0 ? max(5, min(100, (($loan->total_payable - $loan->balance) / $loan->total_payable) * 100)) : 5 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#716a7c]">No loans yet</p>
            @endforelse
        </div>
    </div>

    {{-- About Us --}}
    <section id="about-us" class="scroll-mt-28 rounded-lg border border-[#ded8c8] bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-extrabold uppercase text-[#947b2f]">About Us</p>
        <h2 class="mt-2 text-3xl font-extrabold text-[#241f2f]">Building generational wealth in community</h2>
        <div class="mt-6 grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-4 text-base leading-7 text-[#5f5968]">
                <p>
                    Royalty Sacco is a Christian-based platform for intentional saving and investing — designed to help you build generational wealth while walking alongside a community of like-minded people.
                </p>
                <p>
                    We offer free financial education and structured saving portfolios to help you plan, stay disciplined, and achieve your goals with confidence. Our vision is to empower destinies and rebuild families, communities, and societies through faithful stewardship.
                </p>
                <p>
                    Royalty Sacco is founded by <span class="font-bold text-[#4b2673]">Agape Embassy Ministries International</span>, bringing together faith, purpose, and practical financial growth.
                </p>
            </div>
            <div class="rounded-lg bg-[#241f2f] p-6 text-white">
                <p class="text-sm font-bold uppercase text-[#f1cc4b]">Our Vision</p>
                <p class="mt-4 text-lg font-extrabold leading-snug">Empower destinies. Rebuild families. Strengthen communities.</p>
                <p class="mt-4 text-sm leading-6 text-white/80">
                    We believe wealth is not just personal — it is generational. Royalty Sacco exists to walk with you on that journey, one faithful step at a time.
                </p>
            </div>
        </div>
    </section>

    {{-- Why Royalty Sacco --}}
    <section id="why-royalty-sacco" class="scroll-mt-28 rounded-lg border border-[#ded8c8] bg-[#f8f6f1] p-6 shadow-sm sm:p-8">
        <p class="text-sm font-extrabold uppercase text-[#947b2f]">Why Royalty Sacco</p>
        <h2 class="mt-2 text-3xl font-extrabold text-[#241f2f]">Three reasons members choose us</h2>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            <article class="rounded-lg border border-[#ded8c8] bg-white p-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#4b2673] text-sm font-extrabold text-white">1</div>
                <h3 class="mt-4 text-lg font-extrabold text-[#4b2673]">Free Financial Education</h3>
                <p class="mt-3 text-sm leading-6 text-[#5f5968]">
                    Grow steadily on your wealth journey with practical, faith-aligned financial education — at no extra cost to you.
                </p>
            </article>

            <article class="rounded-lg border border-[#ded8c8] bg-white p-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#4b2673] text-sm font-extrabold text-white">2</div>
                <h3 class="mt-4 text-lg font-extrabold text-[#4b2673]">Community of Crowns</h3>
                <p class="mt-3 text-sm leading-6 text-[#5f5968]">
                    Join small groups of seven called <span class="font-bold text-[#241f2f]">Crowns</span> — where members grow together, build trust, and draw inspiration and encouragement from one another. A Crown group can request higher loan limits than an individual, and members can guarantee each other when applying for credit.
                </p>
            </article>

            <article class="rounded-lg border border-[#ded8c8] bg-white p-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#4b2673] text-sm font-extrabold text-white">3</div>
                <h3 class="mt-4 text-lg font-extrabold text-[#4b2673]">Saving Portfolios</h3>
                <p class="mt-3 text-sm leading-6 text-[#5f5968]">
                    Plan and achieve your goals in a sweatless way with dedicated saving portfolios — separate from your personal savings account, built for the life milestones that matter to you.
                </p>
            </article>
        </div>
    </section>

    {{-- Our Products --}}
    <section id="our-products" class="scroll-mt-28 space-y-6">
        <div class="rounded-lg border border-[#ded8c8] bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase text-[#947b2f]">Our Products</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#241f2f]">Goal-based saving portfolios</h2>
                    <p class="mt-4 max-w-3xl text-base leading-7 text-[#5f5968]">
                        Beyond your personal savings journey, we offer portfolio products for short and long-term goals. Each portfolio keeps your goal separate from your main savings account so you can plan, track, and achieve with clarity.
                    </p>
                </div>
                <button type="button"
                    @click="showPortfolioModal = true"
                    class="shrink-0 rounded-md bg-[#4b2673] px-5 py-3 text-sm font-bold text-white hover:bg-[#3d1d61]">
                    Create a Saving Portfolio
                </button>
            </div>

            @if (session('success'))
                <div class="mt-5 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mt-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ([
                    ['icon' => '🎓', 'title' => 'Education Portfolio', 'body' => 'Save for school fees, tuition, or further studies without mixing funds with daily savings.'],
                    ['icon' => '✈️', 'title' => 'Vacation Portfolio', 'body' => 'Plan your next getaway with a dedicated pot that grows until you are ready to travel.'],
                    ['icon' => '🏗️', 'title' => 'Construction Portfolio', 'body' => 'Build toward a home, renovation, or property project with steady, intentional contributions.'],
                    ['icon' => '💍', 'title' => 'Wedding Portfolio', 'body' => 'Prepare for your special day with a separate savings plan for every celebration detail.'],
                    ['icon' => '🌅', 'title' => 'Retirement Portfolio', 'body' => 'Invest in your future self with long-term savings set apart from everyday spending.'],
                    ['icon' => '🏥', 'title' => 'Health & Medical', 'body' => 'Set aside funds for medical needs, insurance, or wellness goals ahead of time.'],
                    ['icon' => '💼', 'title' => 'Business Portfolio', 'body' => 'Grow capital for a side hustle, startup, or business expansion at your own pace.'],
                    ['icon' => '🚗', 'title' => 'Vehicle Portfolio', 'body' => 'Save toward a car purchase, upgrade, or maintenance fund with a clear target.'],
                ] as $product)
                    <article class="rounded-lg border border-[#ded8c8] bg-[#fbfaf7] p-5">
                        <p class="text-2xl">{{ $product['icon'] }}</p>
                        <h3 class="mt-3 text-base font-extrabold text-[#4b2673]">{{ $product['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#5f5968]">{{ $product['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        @if ($portfolios->isNotEmpty())
            <div class="rounded-lg border border-[#ded8c8] bg-white p-6 shadow-sm sm:p-8">
                <h3 class="text-xl font-extrabold text-[#241f2f]">Your Saving Portfolios</h3>
                <p class="mt-1 text-sm text-[#716a7c]">Track the goal-based portfolios you have created.</p>

                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($portfolios as $portfolio)
                        @php
                            $saved = $portfolio->account->balance ?? 0;
                            $target = $portfolio->target_amount ?? 0;
                            $progress = $target > 0 ? min(100, ($saved / $target) * 100) : 0;
                        @endphp
                        <article class="rounded-lg border border-[#ded8c8] bg-[#fbfaf7] p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase text-[#947b2f]">{{ $portfolio->category_label }}</p>
                                    <h4 class="mt-1 text-lg font-extrabold text-[#241f2f]">{{ $portfolio->name }}</h4>
                                </div>
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-bold capitalize text-green-700">{{ $portfolio->status }}</span>
                            </div>

                            <div class="mt-4">
                                <div class="flex justify-between text-sm">
                                    <span class="font-semibold text-[#4b2673]">
                                        <span x-show="showMoney" x-cloak>KES {{ number_format($saved, 2) }}</span>
                                        <span x-show="! showMoney">KES ******</span>
                                    </span>
                                    @if ($target > 0)
                                        <span class="text-[#716a7c]">Goal: KES {{ number_format($target, 2) }}</span>
                                    @endif
                                </div>
                                @if ($target > 0)
                                    <div class="mt-2 h-2 w-full rounded-full bg-[#eee8dc]">
                                        <div class="h-2 rounded-full bg-[#4b2673]" style="width: {{ max(4, $progress) }}%"></div>
                                    </div>
                                @endif
                            </div>

                            @if ($portfolio->target_date)
                                <p class="mt-3 text-xs text-[#716a7c]">Target date: {{ $portfolio->target_date->format('M j, Y') }}</p>
                            @endif

                            @if ($portfolio->description)
                                <p class="mt-2 text-sm leading-6 text-[#5f5968]">{{ $portfolio->description }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Create Portfolio Modal --}}
        <div x-show="showPortfolioModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto px-4 py-6" style="display: none;">
            <div class="fixed inset-0 bg-[#241f2f]/60" @click="showPortfolioModal = false"></div>

            <div class="relative mx-auto w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase text-[#947b2f]">New Portfolio</p>
                        <h3 class="mt-1 text-xl font-extrabold text-[#241f2f]">Create a Saving Portfolio</h3>
                        <p class="mt-2 text-sm text-[#716a7c]">Set a goal, choose a category, and start saving separately from your personal account.</p>
                    </div>
                    <button type="button" @click="showPortfolioModal = false" class="rounded-md border border-[#ded8c8] px-3 py-1 text-sm font-bold text-[#716a7c]">Close</button>
                </div>

                <form method="POST" action="{{ route('saving-portfolios.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="portfolio_name" class="block text-sm font-bold text-[#241f2f]">Portfolio Name</label>
                        <input id="portfolio_name" name="name" type="text" value="{{ old('name') }}" required
                            placeholder="e.g. My Wedding Fund"
                            class="mt-1 block w-full rounded-md border-[#ded8c8] shadow-sm focus:border-[#4b2673] focus:ring-[#4b2673]">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="portfolio_category" class="block text-sm font-bold text-[#241f2f]">Category</label>
                        <select id="portfolio_category" name="category" required
                            class="mt-1 block w-full rounded-md border-[#ded8c8] shadow-sm focus:border-[#4b2673] focus:ring-[#4b2673]">
                            <option value="">Select a category</option>
                            @foreach (\App\Models\SavingPortfolio::CATEGORIES as $value => $label)
                                <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="target_amount" class="block text-sm font-bold text-[#241f2f]">Target Amount (KES)</label>
                            <input id="target_amount" name="target_amount" type="number" min="1" step="0.01" value="{{ old('target_amount') }}"
                                placeholder="Optional"
                                class="mt-1 block w-full rounded-md border-[#ded8c8] shadow-sm focus:border-[#4b2673] focus:ring-[#4b2673]">
                            @error('target_amount')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="target_date" class="block text-sm font-bold text-[#241f2f]">Target Date</label>
                            <input id="target_date" name="target_date" type="date" value="{{ old('target_date') }}"
                                class="mt-1 block w-full rounded-md border-[#ded8c8] shadow-sm focus:border-[#4b2673] focus:ring-[#4b2673]">
                            @error('target_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="portfolio_description" class="block text-sm font-bold text-[#241f2f]">Description</label>
                        <textarea id="portfolio_description" name="description" rows="3"
                            placeholder="What is this portfolio for?"
                            class="mt-1 block w-full rounded-md border-[#ded8c8] shadow-sm focus:border-[#4b2673] focus:ring-[#4b2673]">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="rounded-md bg-[#4b2673] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#3d1d61]">
                            Create Portfolio
                        </button>
                        <button type="button" @click="showPortfolioModal = false" class="rounded-md border border-[#ded8c8] px-5 py-2.5 text-sm font-bold text-[#5f5968] hover:bg-[#f6f1e6]">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
