@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">💼 My Wallet</h2>

    {{-- SUMMARY CARDS --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Balance</h6>
                    <h3 class="text-success mb-0">
                        {{ number_format($balance ?? 0, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Savings</h6>
                    <h4 class="mb-0">
                        {{ number_format($savings ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Loans</h6>
                    <h4 class="mb-0">
                        {{ $loans->count() ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- RECENT TRANSACTIONS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <strong>Recent Transactions</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($tx->transacted_at)->format('d M Y') }}</td>
                            <td>{{ ucfirst($tx->type) }}</td>
                            <td>
                                <span class="{{ in_array($tx->type, ['withdrawal','fee']) ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($tx->amount, 2) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                No transactions yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- LOANS --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Loans</strong>
        </div>

        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ number_format($loan->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td>{{ $loan->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                No loans found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection