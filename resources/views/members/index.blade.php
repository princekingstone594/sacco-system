<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Members</h2>
            <a href="{{ route('members.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Register Member</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            <form method="GET" class="flex gap-3">
                <x-text-input name="search" class="w-full sm:max-w-md" placeholder="Search member no, name, phone or ID" value="{{ $search }}" />
                <x-primary-button>Search</x-primary-button>
            </form>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Member</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Contact</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Account Balance</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($members as $member)
                                <tr>
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $member->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $member->member_no }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $member->phone ?? 'No phone' }}<br>{{ $member->email }}</td>
                                    <td class="px-5 py-4 text-sm capitalize text-gray-700 dark:text-gray-300">{{ $member->status }}</td>
                                    <td class="px-5 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($member->accounts_sum_balance ?? 0, 2) }}</td>
                                    <td class="px-5 py-4 text-right"><a href="{{ route('members.show', $member) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Open</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-500">No members found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">{{ $members->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
