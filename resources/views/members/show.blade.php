<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $member->full_name }}</h2>
                <p class="text-sm text-gray-500">{{ $member->member_no }} · {{ ucfirst($member->status) }}</p>
            </div>
            <a href="{{ route('members.edit', $member) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Edit Member</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($member->accounts as $account)
                    <a href="{{ route('accounts.show', $account) }}" class="rounded-lg bg-white p-5 shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-900">
                        <p class="text-sm text-gray-500">{{ $account->type_label }}</p>
                        <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($account->balance, 2) }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ $account->account_no }}</p>
                    </a>
                @endforeach
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Member Details</h3>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-gray-500">Phone</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->phone ?? '-' }}</dd></div>
                        <div><dt class="text-gray-500">National ID</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->national_id ?? '-' }}</dd></div>
                        <div><dt class="text-gray-500">Employer</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->employer ?? '-' }}</dd></div>
                        <div><dt class="text-gray-500">Next of Kin</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $member->next_of_kin_name ?? '-' }} {{ $member->next_of_kin_phone ? '('.$member->next_of_kin_phone.')' : '' }}</dd></div>
                    </dl>
                </div>

                <div class="lg:col-span-2 rounded-lg bg-white shadow-sm dark:bg-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Loans</h3>
                        <a href="{{ route('loans.create') }}" class="text-sm font-medium text-indigo-600">Issue loan</a>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($member->loans as $loan)
                            <a href="{{ route('loans.show', $loan) }}" class="flex items-center justify-between p-5 hover:bg-gray-50 dark:hover:bg-gray-900">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $loan->loan_no }}</p>
                                    <p class="text-sm text-gray-500">{{ $loan->product->name }} · Due {{ $loan->due_on->format('M d, Y') }}</p>
                                </div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ number_format($loan->balance, 2) }}</p>
                            </a>
                        @empty
                            <p class="p-5 text-sm text-gray-500">No loans for this member.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
