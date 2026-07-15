<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            ➕ Post Transaction
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- ERRORS -->
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

            <form method="POST" action="{{ route('transactions.store') }}"
                  x-data="{ type: '{{ old('type', 'deposit') }}' }"
                  class="space-y-6">
                @csrf

                <!-- ACCOUNT -->
                <div>
                    <x-input-label for="account_id" value="Select Account" />
                    <select id="account_id" name="account_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>

                        <option value="">-- Choose account --</option>

                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}"
                                @selected((int) old('account_id', $selectedAccount) === $account->id)>

                                {{ $account->account_no }} -
                                {{ $account->member->full_name }}
                                ({{ $account->type_label }})
                                | Bal: KES {{ number_format($account->balance, 2) }}

                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TYPE -->
                <div>
                    <x-input-label for="type" value="Transaction Type" />
                    <select id="type" name="type"
                        x-model="type"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>

                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Dynamic hint -->
                    <div class="mt-2 text-sm font-medium">
                        <p x-show="type === 'deposit'" class="text-green-600">
                            ✔ This will increase account balance
                        </p>
                        <p x-show="type === 'withdrawal'" class="text-red-500">
                            ⚠ This will reduce account balance
                        </p>
                        <p x-show="type === 'fee'" class="text-yellow-600">
                            💰 This will deduct a service fee
                        </p>
                    </div>
                </div>

                <!-- AMOUNT -->
                <div>
                    <x-input-label for="amount" value="Amount (KES)" />
                    <x-text-input id="amount" name="amount" type="number"
                        step="0.01" min="1"
                        value="{{ old('amount') }}"
                        class="mt-1 block w-full rounded-lg"
                        required />
                </div>

                <!-- DATE -->
                <div>
                    <x-input-label for="transacted_at" value="Transaction Date" />
                    <x-text-input id="transacted_at" name="transacted_at"
                        type="date"
                        class="mt-1 block w-full rounded-lg"
                        value="{{ old('transacted_at', now()->format('Y-m-d')) }}"
                        required />
                </div>

                <!-- REFERENCE -->
                <div>
                    <x-input-label for="reference" value="Reference (Optional)" />
                    <x-text-input id="reference" name="reference"
                        value="{{ old('reference') }}"
                        class="mt-1 block w-full rounded-lg" />
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex justify-between items-center pt-4 border-t">

                    <a href="{{ route('transactions.index') }}"
                       class="px-4 py-2 text-gray-600 hover:text-gray-900">
                        ← Cancel
                    </a>

                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                        💾 Post Transaction
                    </button>
                </div>

            </form>

        </div>

    </div>
</x-app-layout>