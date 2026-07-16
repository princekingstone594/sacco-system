@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            My Loans
        </h1>

        <span class="text-sm text-gray-400">
            Track & manage your loans
        </span>
    </div>

    {{-- APPLY LOAN --}}
    <div class="bg-white p-5 rounded-2xl shadow">
        <h3 class="font-semibold mb-3 text-gray-700">Apply for Loan</h3>

        <form method="POST" action="{{ route('loans.store') }}">
            @csrf

            <div class="grid md:grid-cols-3 gap-4">

                <input type="number" name="amount"
                       placeholder="Amount"
                       class="border p-2 rounded-lg" required>

                <input type="number" name="duration"
                       placeholder="Months"
                       class="border p-2 rounded-lg" required>

                <button class="bg-indigo-600 text-white rounded-lg px-4 hover:bg-indigo-700">
                    Apply
                </button>

            </div>
        </form>
    </div>

    {{-- ACTIVE LOAN --}}
    @php
        $activeLoan = $loans->where('status', 'active')->first();
    @endphp

    @if($activeLoan)
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 rounded-2xl shadow">

        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm opacity-80">Active Loan</p>
                <h2 class="text-2xl font-bold">
                    ${{ number_format($activeLoan->amount, 2) }}
                </h2>
            </div>

            <div class="text-right">
                <p class="text-sm opacity-80">Remaining</p>
                <h3 class="text-lg font-semibold">
                    ${{ number_format(
                        $activeLoan->repayments->where('paid', false)->sum('amount') +
                        $activeLoan->repayments->sum('penalty'),
                        2
                    ) }}
                </h3>
            </div>
        </div>

        {{-- PROGRESS --}}
        @php
            $total = $activeLoan->repayments->sum('amount');
            $paid = $activeLoan->repayments->where('paid', true)->sum('amount');
            $percent = $total > 0 ? ($paid / $total) * 100 : 0;
        @endphp

        <div class="mt-4">
            <div class="w-full bg-white/20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full"
                     style="width: {{ $percent }}%"></div>
            </div>

            <p class="text-xs mt-2">
                {{ round($percent) }}% repaid
            </p>
        </div>

    </div>
    @endif

    {{-- REPAYMENT SCHEDULE --}}
    @if($activeLoan)
    <div class="bg-white p-5 rounded-2xl shadow">

        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            Repayment Schedule
        </h3>

        @foreach($activeLoan->repayments as $repay)
            <div class="flex justify-between items-center py-2 border-b last:border-none">

                <div>
                    <p class="text-sm text-gray-700">
                        ${{ number_format($repay->amount, 2) }}
                    </p>

                    {{-- PENALTY --}}
                    @if($repay->penalty > 0)
                        <p class="text-xs text-red-500">
                            Penalty: ${{ number_format($repay->penalty, 2) }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-400">
                        Due: {{ $repay->due_date->format('M d, Y') }}
                    </p>
                </div>

                <span class="text-xs px-2 py-1 rounded-full
                    {{ $repay->paid
                        ? 'bg-green-100 text-green-600'
                        : ($repay->overdue
                            ? 'bg-red-100 text-red-600'
                            : 'bg-yellow-100 text-yellow-600') }}">
                    
                    @if($repay->paid)
                        Paid
                    @elseif($repay->overdue)
                        Overdue
                    @else
                        Pending
                    @endif

                </span>

            </div>
        @endforeach

    </div>
    @endif

    {{-- ALL LOANS HISTORY --}}
    <div class="bg-white p-5 rounded-2xl shadow">

        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            Loan History
        </h3>

        @forelse($loans as $loan)
            <div class="flex justify-between items-center py-2 border-b last:border-none">

                <div>
                    <p class="font-medium text-gray-800">
                        ${{ number_format($loan->amount, 2) }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $loan->duration_months }} months
                    </p>
                </div>

                <span class="text-xs px-2 py-1 rounded-full capitalize
                    {{
                        match($loan->status) {
                            'approved' => 'bg-blue-100 text-blue-600',
                            'active' => 'bg-green-100 text-green-600',
                            'completed' => 'bg-gray-200 text-gray-600',
                            'rejected' => 'bg-red-100 text-red-600',
                            default => 'bg-yellow-100 text-yellow-600',
                        }
                    }}">
                    {{ $loan->status }}
                </span>

            </div>
        @empty
            <p class="text-sm text-gray-400">No loans yet</p>
        @endforelse

    </div>

</div>
@endsection