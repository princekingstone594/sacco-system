<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Post Transaction</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('transactions.store') }}" class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                @csrf
                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input-label for="account_id" value="Account" />
                        <select id="account_id" name="account_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" @selected((int) old('account_id', $selectedAccount) === $account->id)>{{ $account->account_no }} - {{ $account->member->full_name }} ({{ $account->type_label }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="type" value="Type" />
                        <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach ($types as $value => $label)
                                <option value="{{ $value }}" @selected(old('type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="amount" value="Amount" />
                        <x-text-input id="amount" name="amount" type="number" min="1" step="0.01" class="mt-1 block w-full" value="{{ old('amount') }}" required />
                    </div>
                    <div>
                        <x-input-label for="reference" value="Reference" />
                        <x-text-input id="reference" name="reference" class="mt-1 block w-full" value="{{ old('reference') }}" />
                    </div>
                    <div>
                        <x-input-label for="transacted_at" value="Transaction Date" />
                        <x-text-input id="transacted_at" name="transacted_at" type="date" class="mt-1 block w-full" value="{{ old('transacted_at', now()->format('Y-m-d')) }}" required />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('transactions.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                    <x-primary-button>Post Transaction</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
