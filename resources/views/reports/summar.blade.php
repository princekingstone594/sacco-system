@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">Financial Overview</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Savings</p>
            <h2 class="text-xl font-bold">₱{{ number_format($totalSavings, 2) }}</h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Loans Issued</p>
            <h2 class="text-xl font-bold">₱{{ number_format($totalLoans, 2) }}</h2>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Repaid</p>
            <h2 class="text-xl font-bold">₱{{ number_format($totalRepaid, 2) }}</h2>
        </div>

    </div>

</div>
@endsection