@extends('layouts.app')

@section('header', '💳 Transactions')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Transactions</h1>

        <a href="{{ route('transactions.create') }}"
           class="bg-indigo-500 px-4 py-2 rounded-lg text-sm hover:bg-indigo-600">
            + New Transaction
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-gray-800 rounded-xl overflow-hidden">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Member</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-700">

                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-700/50">

                        <td class="px-4 py-3">
                            {{ $transaction->member->name ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-3 capitalize">
                            {{ $transaction->type }}
                        </td>

                        <td class="px-4 py-3 font-semibold text-green-400">
                            KES {{ number_format($transaction->amount) }}
                        </td>

                        <td class="px-4 py-3 text-gray-400">
                            {{ $transaction->created_at->format('d M Y') }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            No transactions found
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

</div>

@endsection