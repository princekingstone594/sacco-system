<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Loan</h2></x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('loans.update', $loan) }}" class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                @csrf
                @method('PATCH')
                <div class="grid gap-5">
                    <div>
                        <x-input-label for="loan_no" value="Loan Number" />
                        <x-text-input id="loan_no" name="loan_no" class="mt-1 block w-full" value="{{ old('loan_no', $loan->loan_no) }}" required />
                    </div>
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach (['active' => 'Active', 'paid' => 'Paid', 'defaulted' => 'Defaulted', 'written_off' => 'Written Off'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $loan->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="purpose" value="Purpose" />
                        <textarea id="purpose" name="purpose" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose', $loan->purpose) }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('loans.show', $loan) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                    <x-primary-button>Update Loan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
