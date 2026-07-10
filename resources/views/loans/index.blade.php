<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Loans</h2>

            <a href="{{ route('loans.create') }}"
               class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Issue Loan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">

            <!-- FILTER -->
            <form method="GET" class="flex max-w-sm gap-3">
                <select name="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="">All statuses</option>

                    @foreach ([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'disbursed' => 'Disbursed',
                        'completed' => 'Completed',
                        'rejected' => 'Rejected'
                    ] as $value => $label)

                        <option value="{{ $value }}" @selected(request('status') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach

                </select>

                <x-primary-button>Filter</x-primary-button>
            </form>

            <!-- TABLE -->
            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">

                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">

                    <!-- HEAD -->
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Loan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Member</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Product</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Due</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Balance</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Actions</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                <!-- LOAN -->
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $loan->loan_no }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        KES {{ number_format($loan->principal, 2) }}
                                    </p>
                                </td>

                                <!-- MEMBER -->
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $loan->member->full_name }}
                                </td>

                                <!-- PRODUCT -->
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $loan->product->name }}
                                </td>

                                <!-- DUE -->
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ optional($loan->due_on)->format('M d, Y') }}
                                </td>

                                <!-- BALANCE -->
                                <td class="px-5 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($loan->balance, 2) }}
                                </td>

                                <!-- STATUS -->
                                <td class="px-5 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($loan->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($loan->status === 'approved') bg-blue-100 text-blue-700
                                        @elseif($loan->status === 'disbursed') bg-green-100 text-green-700
                                        @elseif($loan->status === 'completed') bg-gray-200 text-gray-700
                                        @elseif($loan->status === 'rejected') bg-red-100 text-red-700
                                        @endif
                                    ">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">

                                        <!-- VIEW -->
                                        <a href="{{ route('loans.show', $loan) }}"
                                           class="text-indigo-600 text-sm font-medium hover:underline">
                                            Open
                                        </a>

                                        <!-- APPROVE / REJECT -->
                                        @if($loan->isPending())
                                            <form method="POST" action="{{ route('loans.approve', $loan) }}">
                                                @csrf
                                                <button class="text-blue-600 text-sm hover:underline">
                                                    Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('loans.reject', $loan) }}">
                                                @csrf
                                                <button class="text-red-600 text-sm hover:underline">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        <!-- DISBURSE -->
                                        @if($loan->isApproved())
                                            <form method="POST" action="{{ route('loans.disburse', $loan) }}">
                                                @csrf
                                                <button class="text-green-600 text-sm hover:underline">
                                                    Disburse
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-sm text-gray-500">
                                    No loans found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">
                    {{ $loans->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>