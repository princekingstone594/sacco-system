<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Royalty Sacco | Empowering Destinies</title>
    <meta name="description" content="Royalty Sacco is a digital Sacco platform for members, savings, loans, shares, dividends, and financial operations.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-[#f8f6f1] font-sans text-[#241f2f] antialiased">
    <header class="sticky top-0 z-30 border-b border-[#ded8c8] bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="#home" class="flex min-w-0 items-center gap-3">
                <img src="{{ asset('royalty-sacco-logo.png') }}" alt="Royalty Sacco" class="h-12 w-12 rounded-lg object-contain">
                <div class="min-w-0">
                    <p class="truncate text-sm font-extrabold uppercase text-[#4b2673]">Royalty Sacco</p>
                    <p class="truncate text-xs font-semibold text-[#a88624]">Empowering Destinies</p>
                </div>
            </a>

            <div class="hidden items-center gap-6 text-sm font-semibold text-[#5f5968] md:flex">
                <a href="#modules" class="hover:text-[#4b2673]">Modules</a>
                <a href="#portals" class="hover:text-[#4b2673]">Portals</a>
                <a href="#roadmap" class="hover:text-[#4b2673]">Roadmap</a>
                <a href="#contact" class="hover:text-[#4b2673]">Contact</a>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md bg-[#4b2673] px-4 py-2 text-sm font-bold text-white hover:bg-[#3d1d61]">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden rounded-md border border-[#ded8c8] px-4 py-2 text-sm font-bold text-[#4b2673] hover:bg-[#f6f1e6] sm:inline-flex">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md bg-[#4b2673] px-4 py-2 text-sm font-bold text-white hover:bg-[#3d1d61]">Join</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main id="home">
        <section class="relative min-h-[88vh] overflow-hidden bg-[#241f2f] text-white">
            <img
                src="https://images.unsplash.com/photo-1560439514-4e9645039924?auto=format&fit=crop&w=1800&q=80"
                alt="African professionals discussing finance"
                class="absolute inset-0 h-full w-full object-cover opacity-45"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#241f2f] via-[#241f2f]/80 to-[#4b2673]/45"></div>

            <div class="relative mx-auto flex min-h-[88vh] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <div class="mb-6 inline-flex rounded-md bg-white/10 px-4 py-2 text-sm font-semibold text-[#f1cc4b] ring-1 ring-white/20">
                        Digital Sacco operations for savings, credit, and member trust
                    </div>
                    <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">
                        Royalty Sacco
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-white/88">
                        A modern Sacco platform for member onboarding, contributions, loans, reports, audit trails, and self-service access. Built toward a SaaS-level fintech system for Kenyan and African cooperative finance.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md bg-[#f1cc4b] px-5 py-3 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">Open Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="rounded-md bg-[#f1cc4b] px-5 py-3 text-sm font-extrabold text-[#241f2f] hover:bg-[#e1bb37]">Create Account</a>
                            <a href="{{ route('login') }}" class="rounded-md border border-white/35 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Member Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-[#ded8c8] bg-white">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-px bg-[#ded8c8] sm:grid-cols-4">
                @foreach ([
                    ['label' => 'Core Modules', 'value' => '8+'],
                    ['label' => 'Role Portals', 'value' => '2'],
                    ['label' => 'Audit Ready', 'value' => 'On'],
                    ['label' => 'SaaS Direction', 'value' => 'Next'],
                ] as $stat)
                    <div class="bg-white px-4 py-6 text-center">
                        <p class="text-2xl font-extrabold text-[#4b2673]">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-xs font-bold uppercase text-[#716a7c]">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="modules" class="bg-[#f8f6f1] py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-sm font-extrabold uppercase text-[#a88624]">Foundation now</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#241f2f]">The next build step is product coherence.</h2>
                    <p class="mt-4 text-base leading-7 text-[#5f5968]">
                        The project already has early foundations for members, accounts, transactions, loans, reports, authentication, admin routing, and audit logs. The immediate priority is to turn those pieces into a clean admin and member experience before moving into billing, tenant isolation, M-Pesa, SMS, 2FA, and AI insights.
                    </p>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['title' => 'Member Management', 'body' => 'Profiles, KYC readiness, account links, and role-aware access.'],
                        ['title' => 'Savings & Contributions', 'body' => 'Deposits, withdrawals, wallet views, balances, and ledger growth.'],
                        ['title' => 'Loans', 'body' => 'Applications, approvals, disbursement tracking, schedules, and repayments.'],
                        ['title' => 'Reports', 'body' => 'Contribution summaries, loan performance, transaction exports, and statements.'],
                        ['title' => 'Security & Compliance', 'body' => 'Audit logging exists; next comes 2FA, policy controls, and stronger encryption posture.'],
                        ['title' => 'SaaS Architecture', 'body' => 'Multi-tenancy, subscriptions, billing, integrations, monitoring, and CI/CD.'],
                    ] as $module)
                        <article class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-extrabold text-[#4b2673]">{{ $module['title'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-[#5f5968]">{{ $module['body'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="portals" class="bg-white py-20">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_1.1fr] lg:px-8">
                <div>
                    <p class="text-sm font-extrabold uppercase text-[#a88624]">Two experiences</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-[#241f2f]">Admin control and member self-service belong side by side.</h2>
                    <p class="mt-4 text-base leading-7 text-[#5f5968]">
                        Admins should manage members, products, approvals, transactions, and reports. Members should see balances, request loans, track repayments, and download statements without calling the office for every update.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg bg-[#241f2f] p-6 text-white">
                        <p class="text-sm font-bold uppercase text-[#f1cc4b]">Admin End</p>
                        <ul class="mt-5 space-y-3 text-sm leading-6 text-white/85">
                            <li>Member onboarding and account oversight</li>
                            <li>Loan product setup and approval workflows</li>
                            <li>Reports, audit logs, and operational health</li>
                            <li>Future billing, tenants, SMS, M-Pesa, and monitoring</li>
                        </ul>
                    </div>
                    <div class="rounded-lg bg-[#f6f1e6] p-6">
                        <p class="text-sm font-bold uppercase text-[#4b2673]">Member End</p>
                        <ul class="mt-5 space-y-3 text-sm leading-6 text-[#5f5968]">
                            <li>Wallet balances and contribution history</li>
                            <li>Loan applications and repayment progress</li>
                            <li>Notifications for approvals and reminders</li>
                            <li>Downloadable statements and profile updates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="roadmap" class="bg-[#241f2f] py-20 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
                    <div>
                        <p class="text-sm font-extrabold uppercase text-[#f1cc4b]">Build order</p>
                        <h2 class="mt-2 text-3xl font-extrabold">Where we go next.</h2>
                        <p class="mt-4 text-base leading-7 text-white/75">
                            We should finish the first version of the operating system before selling it as SaaS. That means clean UX, reliable ledgers, accurate reports, role separation, tests, and then the SaaS layer.
                        </p>
                    </div>
                    <div class="grid gap-3">
                        @foreach ([
                            'Stabilize navigation, branding, dashboard layout, and route coverage.',
                            'Harden the core ledger: account balances, transaction posting, reversals, and audit history.',
                            'Complete loan lifecycle: products, application, approval, disbursement, schedule, repayment, arrears.',
                            'Add member statements, admin reports, exports, and financial summaries.',
                            'Add 2FA, permissions, notifications, M-Pesa/SMS/email, and production monitoring.',
                            'Move into SaaS: tenant isolation, plans, billing, onboarding, backups, and deployment pipeline.',
                        ] as $index => $step)
                            <div class="flex gap-4 rounded-lg border border-white/10 bg-white/6 p-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-[#f1cc4b] text-sm font-extrabold text-[#241f2f]">{{ $index + 1 }}</span>
                                <p class="text-sm leading-6 text-white/82">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="bg-white py-16">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-[#241f2f]">Ready for the next sprint.</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#5f5968]">
                        The system is now positioned as a real Sacco product: public site, admin workspace, member portal, and a practical roadmap into fintech-grade SaaS.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="rounded-md border border-[#ded8c8] px-5 py-3 text-sm font-bold text-[#4b2673] hover:bg-[#f6f1e6]">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md bg-[#4b2673] px-5 py-3 text-sm font-bold text-white hover:bg-[#3d1d61]">Register</a>
                    @endif
                </div>
            </div>
        </section>
    </main>
</body>
</html>
