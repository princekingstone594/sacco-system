@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">
        📊 Financial Reports
    </h1>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Savings</p>
            <h2 class="text-xl font-bold text-green-600">
                ₱{{ number_format($totalSavings, 2) }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-sm text-gray-500">Active Loans</p>
            <h2 class="text-xl font-bold text-blue-600">
                ₱{{ number_format($activeLoans, 2) }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-sm text-gray-500">Repaid Loans</p>
            <h2 class="text-xl font-bold text-indigo-600">
                ₱{{ number_format($repaidLoans, 2) }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-sm text-gray-500">Transactions</p>
            <h2 class="text-xl font-bold text-purple-600">
                {{ $transactionCount }}
            </h2>
        </div>

    </div>

    <div class="flex gap-3">
        <a href="{{ route('reports.pdf') }}" class="bg-red-600 px-4 py-2 rounded">
           Download PDF
        </a>

        <a href="{{ route('reports.excel') }}" class="bg-green-600 px-4 py-2 rounded">
           Export Excel
        </a>
    </div>

</div>
@endsection