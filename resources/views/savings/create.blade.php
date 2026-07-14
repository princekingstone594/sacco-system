<x-app-layout>

    <x-slot name="header">
        Deposit Money
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow max-w-lg">

        <form method="POST" action="{{ route('savings.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm mb-1">Amount</label>
                <input type="number" name="amount" step="0.01"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                Deposit
            </button>

        </form>

    </div>

</x-app-layout>