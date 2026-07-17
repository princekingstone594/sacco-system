<h1>Financial Report</h1>

<p>Total Savings: {{ $totalSavings }}</p>

<table border="1" width="100%">
    <tr>
        <th>Date</th>
        <th>Amount</th>
        <th>Type</th>
    </tr>

    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->transacted_at }}</td>
        <td>{{ $t->amount }}</td>
        <td>{{ $t->type }}</td>
    </tr>
    @endforeach
</table>