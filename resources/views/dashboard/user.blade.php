@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white p-6">

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- 🔥 WALLET CARD -->
        <div class="relative bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500 rounded-2xl p-6 shadow-2xl overflow-hidden">

            <div class="absolute top-0 right-0 opacity-20 text-9xl font-bold pr-6 pt-2">
                ₱
            </div>

            <p class="text-sm opacity-80">Total Balance</p>
            <h1 class="text-4xl font-bold mt-1">₱{{ number_format($balance, 2) }}</h1>

            <div class="flex gap-6 mt-4 text-sm">
                <div>
                    <p class="opacity-70">Savings</p>
                    <p class="font-semibold">₱{{ number_format($savings, 2) }}</p>
                </div>
                <div>
                    <p class="opacity-70">Loan Balance</p>
                    <p class="font-semibold">
                        ₱{{ number_format($loans->where('status','approved')->sum('amount'),2) }}
                    </p>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex gap-3 mt-6">
                <button onclick="openModal('depositModal')" 
                    class="bg-white text-black px-4 py-2 rounded-lg font-semibold hover:scale-105 transition">
                    + Deposit
                </button>

                <button onclick="openModal('withdrawModal')" 
                    class="bg-black/30 border border-white px-4 py-2 rounded-lg hover:bg-black/50 transition">
                    − Withdraw
                </button>
            </div>
        </div>

        <!-- 🔄 QUICK STATS -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-gray-800 p-4 rounded-xl">
                <p class="text-gray-400 text-xs">Transactions</p>
                <h2 class="text-lg font-bold">{{ $transactions->count() }}</h2>
            </div>

            <div class="bg-gray-800 p-4 rounded-xl">
                <p class="text-gray-400 text-xs">Active Loans</p>
                <h2 class="text-lg font-bold">{{ $loans->count() }}</h2>
            </div>

            <div class="bg-gray-800 p-4 rounded-xl">
                <p class="text-gray-400 text-xs">Status</p>
                <h2 class="text-green-400 font-bold">Active</h2>
            </div>
        </div>

        <!-- 📜 TRANSACTIONS -->
        <div class="bg-gray-800 rounded-2xl p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Recent Activity</h2>
            </div>

            <div class="space-y-3">
                @forelse($transactions as $tx)
                    <div class="flex justify-between items-center bg-gray-900 p-3 rounded-lg">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ $tx->type }}</p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($tx->transacted_at)->format('M d, Y') }}
                            </p>
                        </div>

                        <p class="font-semibold 
                            {{ $tx->type === 'deposit' ? 'text-green-400' : 'text-red-400' }}">
                            {{ $tx->type === 'deposit' ? '+' : '-' }}
                            ₱{{ number_format($tx->amount, 2) }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No transactions yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 💰 Deposit Modal -->
<div id="depositModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center">
    <div class="bg-gray-900 p-6 rounded-xl w-80">
        <h2 class="text-lg font-semibold mb-4">Deposit</h2>

        <input type="number" id="depositAmount"
            class="w-full p-2 rounded bg-gray-800 border border-gray-700 mb-4"
            placeholder="Enter amount">

        <button onclick="submitDeposit()"
            class="w-full bg-green-500 py-2 rounded hover:bg-green-600">
            Confirm
        </button>

        <button onclick="closeModal('depositModal')"
            class="w-full mt-2 text-gray-400 text-sm">Cancel</button>
    </div>
</div>

<!-- 💸 Withdraw Modal -->
<div id="withdrawModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center">
    <div class="bg-gray-900 p-6 rounded-xl w-80">
        <h2 class="text-lg font-semibold mb-4">Withdraw</h2>

        <input type="number" id="withdrawAmount"
            class="w-full p-2 rounded bg-gray-800 border border-gray-700 mb-4"
            placeholder="Enter amount">

        <button onclick="submitWithdraw()"
            class="w-full bg-red-500 py-2 rounded hover:bg-red-600">
            Confirm
        </button>

        <button onclick="closeModal('withdrawModal')"
            class="w-full mt-2 text-gray-400 text-sm">Cancel</button>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function submitDeposit() {
    let amount = document.getElementById('depositAmount').value;

    fetch('/wallet/deposit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount: amount })
    })
    .then(res => res.json())
    .then(data => {
        location.reload();
    });
}

function submitWithdraw() {
    let amount = document.getElementById('withdrawAmount').value;

    fetch('/wallet/withdraw', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount: amount })
    })
    .then(res => res.json())
    .then(data => {
        location.reload();
    });
}
</script>

@endsection