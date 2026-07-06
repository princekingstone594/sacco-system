<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Loans</h2>
            <a href="{{ route('loans.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Issue Loan</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex max-w-sm gap-3">
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All statuses</option>
                    @foreach (['active' => 'Active', 'paid' => 'Paid', 'defaulted' => 'Defaulted', 'written_off' => 'Written Off'] as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-primary-button>Filter</x-primary-button>
            </form>
            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Loan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Product</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Due</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Balance</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($loans as $loan)
                            <tr>
                                <td class="px-5 py-4"><p class="font-medium text-gray-900 dark:text-white">{{ $loan->loan_no }}</p><p class="text-sm capitalize text-gray-500">{{ $loan->status }}</p></td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $loan->member->full_name }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $loan->product->name }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $loan->due_on->format('M d, Y') }}</td>
                                <td class="px-5 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($loan->balance, 2) }}</td>
                                <td class="px-5 py-4 text-right"><a href="{{ route('loans.show', $loan) }}" class="text-sm font-medium text-indigo-600">Open</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No loans found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">{{ $loans->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
