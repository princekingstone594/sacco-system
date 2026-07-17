@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- 🔹 Page Title --}}
    <h1 class="text-2xl font-bold mb-6">💰 My Wallet</h1>

    {{-- 🔹 Balance Card --}}
    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-600">Current Balance</h2>

        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ number_format($balance ?? 0, 2) }}
        </p>
    </div>

    {{-- 🔹 Actions --}}
    <div class="flex gap-4 mb-6">
        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            ➕ Deposit
        </a>

        <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            ➖ Withdraw
        </a>
    </div>

    {{-- 🔹 Transactions --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🧾 Recent Transactions</h2>

        @if(isset($transactions) && $transactions->count())
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Date</th>
                        <th class="py-2">Type</th>
                        <th class="py-2">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ \Carbon\Carbon::parse($transaction->transacted_at)->format('M d, Y') }}
                            </td>

                            <td class="py-2 capitalize">
                                {{ $transaction->type }}
                            </td>

                            <td class="py-2 font-semibold 
                                {{ $transaction->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                
                                {{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No transactions yet.</p>
        @endif
    </div>

</div>
@endsection