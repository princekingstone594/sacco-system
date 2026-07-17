@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Transaction Report</h1>

    <table class="w-full bg-white rounded-xl shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3">Member</th>
                <th class="p-3">Type</th>
                <th class="p-3">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $tx)
            <tr class="border-b">
                <td class="p-3">{{ $tx->member->name ?? '-' }}</td>
                <td class="p-3">{{ ucfirst($tx->type) }}</td>
                <td class="p-3">₱{{ number_format($tx->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection