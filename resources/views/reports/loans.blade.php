@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Loan Report</h1>

    <table class="w-full bg-white rounded-xl shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3">Member</th>
                <th class="p-3">Amount</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr class="border-b">
                <td class="p-3">{{ $loan->member->name }}</td>
                <td class="p-3">₱{{ number_format($loan->amount, 2) }}</td>
                <td class="p-3">{{ ucfirst($loan->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection