<x-app-layout>
    <x-slot name="header">
        Post Transaction
    </x-slot>

    <div class="max-w-3xl mx-auto">

        <div class="bg-white p-6 rounded-xl shadow-sm">

            <form method="POST" action="{{ route('transactions.store') }}"
                  x-data="{ type: '{{ old('type', 'deposit') }}' }"
                  class="space-y-5">
                @csrf

                <!-- ACCOUNT -->
                <div>
                    <x-input-label for="account_id" value="Account" />
                    <select id="account_id" name="account_id"
                        class="mt-1 block w-full rounded-md border-gray-300"
                        required>

                        <option value="">Select account</option>

                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}"
                                @selected((int) old('account_id', $selectedAccount) === $account->id)>

                                {{ $account->account_no }} -
                                {{ $account->member->full_name }}
                                ({{ $account->type_label }})
                                | Bal: {{ number_format($account->balance, 2) }}

                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TYPE -->
                <div>
                    <x-input-label for="type" value="Type" />
                    <select id="type" name="type"
                        x-model="type"
                        class="mt-1 block w-full rounded-md border-gray-300"
                        required>

                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Dynamic hint -->
                    <p class="text-sm mt-2"
                       :class="type === 'deposit' ? 'text-green-600' : 'text-red-500'">
                        <span x-show="type === 'deposit'">This will increase account balance</span>
                        <span x-show="type === 'withdrawal'">This will reduce account balance</span>
                        <span x-show="type === 'fee'">This will deduct a fee</span>
                    </p>
                </div>

                <!-- AMOUNT -->
                <div>
                    <x-input-label for="amount" value="Amount" />
                    <x-text-input id="amount" name="amount" type="number"
                        step="0.01" min="1" class="mt-1 block w-full" required />
                </div>

                <!-- DATE -->
                <div>
                    <x-input-label for="transacted_at" value="Transaction Date" />
                    <x-text-input id="transacted_at" name="transacted_at"
                        type="date" class="mt-1 block w-full"
                        value="{{ now()->format('Y-m-d') }}" required />
                </div>

                <!-- REFERENCE -->
                <div>
                    <x-input-label for="reference" value="Reference" />
                    <x-text-input id="reference" name="reference"
                        class="mt-1 block w-full" />
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('transactions.index') }}"
                       class="px-4 py-2 border rounded-md text-gray-700">
                        Cancel
                    </a>

                    <x-primary-button>
                        Post Transaction
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>
</x-app-layout>