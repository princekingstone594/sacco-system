<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $loan->loan_no }}</h2>
                <p class="text-sm text-gray-500">{{ $loan->member->full_name }} · {{ $loan->product->name }}</p>
            </div>
            <a href="{{ route('loans.edit', $loan) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Edit Loan</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800"><p class="text-sm text-gray-500">Principal</p><p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($loan->principal, 2) }}</p></div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800"><p class="text-sm text-gray-500">Total Payable</p><p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($loan->total_payable, 2) }}</p></div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800"><p class="text-sm text-gray-500">Balance</p><p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($loan->balance, 2) }}</p></div>
                <div class="rounded-lg bg-white p-5 shadow-sm dark:bg-gray-800"><p class="text-sm text-gray-500">Due Date</p><p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ $loan->due_on->format('M d, Y') }}</p></div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Record Repayment</h3>
                    <form method="POST" action="{{ route('loans.repayments.store', $loan) }}" class="mt-5 space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="amount" value="Amount" />
                            <x-text-input id="amount" name="amount" type="number" min="1" step="0.01" max="{{ $loan->balance }}" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="reference" value="Reference" />
                            <x-text-input id="reference" name="reference" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="paid_on" value="Paid On" />
                            <x-text-input id="paid_on" name="paid_on" type="date" class="mt-1 block w-full" value="{{ now()->format('Y-m-d') }}" required />
                        </div>
                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        <x-primary-button>Save Repayment</x-primary-button>
                    </form>
                </div>

                <div class="lg:col-span-2 overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                    <div class="border-b border-gray-100 p-5 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Repayment History</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Date</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Reference</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($loan->repayments as $repayment)
                                <tr>
                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $repayment->paid_on->format('M d, Y') }}</td>
                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $repayment->reference ?? '-' }}</td>
                                    <td class="px-5 py-4 text-right text-sm font-semibold text-green-600">{{ number_format($repayment->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500">No repayments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
