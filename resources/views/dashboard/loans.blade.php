@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">My Loans</h1>

    {{-- APPLY --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <form method="POST" action="{{ route('loans.store') }}">
            @csrf

            <div class="grid md:grid-cols-3 gap-4">
                <input type="number" name="amount" placeholder="Amount"
                       class="border p-2 rounded" required>

                <input type="number" name="duration" placeholder="Months"
                       class="border p-2 rounded" required>

                <button class="bg-indigo-600 text-white rounded px-4">
                    Apply
                </button>
            </div>
        </form>
    </div>

    {{-- LIST --}}
    <div class="bg-white p-5 rounded-xl shadow">
        @forelse($loans as $loan)
            <div class="border-b py-3 flex justify-between">
                <div>
                    <p class="font-semibold">
                        ${{ number_format($loan->amount, 2) }}
                    </p>
                    <p class="text-sm text-gray-400">
                        {{ $loan->duration_months }} months
                    </p>
                </div>

                <span class="text-sm capitalize">
                    {{ $loan->status }}
                </span>
            </div>
        @empty
            <p>No loans yet</p>
        @endforelse
    </div>

</div>
@endsection