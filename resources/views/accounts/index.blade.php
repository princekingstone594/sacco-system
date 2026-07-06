<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Accounts</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex max-w-sm gap-3">
                <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All account types</option>
                    @foreach ($types as $value => $label)
                        <option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-primary-button>Filter</x-primary-button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Account</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Type</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Balance</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($accounts as $account)
                            <tr>
                                <td class="px-5 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $account->account_no }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $account->member->full_name }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $account->type_label }}</td>
                                <td class="px-5 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($account->balance, 2) }}</td>
                                <td class="px-5 py-4 text-right"><a href="{{ route('accounts.show', $account) }}" class="text-sm font-medium text-indigo-600">Ledger</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">{{ $accounts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
