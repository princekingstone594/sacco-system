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

            <h1 id="balance"
                data-value="{{ $balance }}"
                class="text-4xl font-bold mt-1">
                ₱{{ number_format($balance, 2) }}
            </h1>

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

            <div class="flex gap-3 mt-6">
                <button onclick="openModal('deposit')"
                    class="bg-white text-black px-4 py-2 rounded-lg font-semibold
                           hover:scale-105 active:scale-95 transition">
                    + Deposit
                </button>

                <button onclick="openModal('withdraw')"
                    class="bg-black/30 border border-white px-4 py-2 rounded-lg
                           hover:bg-black/50 hover:scale-105 active:scale-95 transition">
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
            <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>

            <!-- ✅ ONLY CHANGE HERE -->
            <div id="transactionList" class="space-y-3">
                @forelse($transactions as $tx)
                    <div class="flex justify-between items-center bg-gray-900 p-3 rounded-lg">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ $tx->type }}</p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($tx->transacted_at)->format('M d, Y') }}
                            </p>
                        </div>

                        <p class="font-semibold {{ $tx->type === 'deposit' ? 'text-green-400' : 'text-red-400' }}">
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

<!-- MODAL + TOAST unchanged -->

<script>
let actionType = '';

function openModal(type) {
    actionType = type;

    document.getElementById('modalTitle').innerText =
        type === 'deposit' ? '💰 Deposit Funds' : '💸 Withdraw Funds';

    const modal = document.getElementById('modal');
    const box = document.getElementById('modalBox');

    modal.classList.remove('hidden');

    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('modal');
    const box = document.getElementById('modalBox');

    box.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

/* 🔄 AJAX SUBMIT */
document.getElementById('walletForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/wallet/${actionType}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            animateBalance(data.balance);

            // ✅ ONLY ADDITION (LIVE TRANSACTION)
            addTransaction({
                type: actionType,
                amount: formData.get('amount'),
                date: new Date().toLocaleDateString('en-US', {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                })
            });

            showToast(data.message);
            closeModal();
        }
    });
});

/* 💎 ADD THIS FUNCTION */
function addTransaction(tx) {
    const list = document.getElementById('transactionList');

    const item = document.createElement('div');
    item.className = "flex justify-between items-center bg-gray-900 p-3 rounded-lg";

    item.innerHTML = `
        <div>
            <p class="text-sm font-medium capitalize">${tx.type}</p>
            <p class="text-xs text-gray-400">${tx.date}</p>
        </div>

        <p class="font-semibold ${tx.type === 'deposit' ? 'text-green-400' : 'text-red-400'}">
            ${tx.type === 'deposit' ? '+' : '-'}
            ₱${parseFloat(tx.amount).toLocaleString(undefined, {minimumFractionDigits: 2})}
        </p>
    `;

    list.prepend(item);

    if (list.children.length > 10) {
        list.removeChild(list.lastChild);
    }
}

/* 💎 BALANCE ANIMATION (UNCHANGED) */
function animateBalance(newBalance) {
    const el = document.getElementById('balance');
    let current = parseFloat(el.dataset.value);

    const duration = 500;
    const start = performance.now();

    function update(time) {
        const progress = Math.min((time - start) / duration, 1);
        const value = current + (newBalance - current) * progress;

        el.innerText = '₱' + value.toLocaleString(undefined, {minimumFractionDigits: 2});
        
        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            el.dataset.value = newBalance;
        }
    }

    requestAnimationFrame(update);
}

/* 🔔 TOAST (UNCHANGED) */
function showToast(message) {
    const toast = document.getElementById('toast');

    toast.innerText = message;
    toast.classList.remove('opacity-0', 'translate-y-5');

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-5');
    }, 2500);
}
</script>

@endsection