@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Loan Management</h1>

    @foreach($loans as $loan)
        <div class="bg-white p-4 rounded shadow mb-4 flex justify-between items-center">

            <div>
                <p class="font-semibold">
                    {{ $loan->member->user->name }}
                </p>
                <p class="text-sm text-gray-500">
                    ${{ number_format($loan->amount, 2) }} • {{ $loan->status }}
                </p>
            </div>

            <div class="flex gap-2">

                @if($loan->status === 'pending')
                    <form method="POST" action="{{ route('admin.loans.approve', $loan) }}">
                        @csrf
                        <button class="bg-green-500 text-white px-3 py-1 rounded">
                            Approve
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.loans.reject', $loan) }}">
                        @csrf
                        <button class="bg-red-500 text-white px-3 py-1 rounded">
                            Reject
                        </button>
                    </form>
                @endif

                @if($loan->status === 'approved')
                    <form method="POST" action="{{ route('admin.loans.disburse', $loan) }}">
                        @csrf
                        <button class="bg-indigo-600 text-white px-3 py-1 rounded">
                            Disburse
                        </button>
                    </form>
                @endif

                @if($loan->status === 'active')
                    <form method="POST" action="{{ route('admin.loans.repayments.store', $loan) }}">
                        @csrf
                        <button class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Record Payment
                        </button>
                    </form>
                @endif

            </div>
        </div>
    @endforeach

</div>
@endsection