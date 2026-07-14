<x-app-layout>
    <x-slot name="header">
        Loans
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white p-6">

        <div class="max-w-7xl mx-auto space-y-6">

            <!-- HEADER -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">Loans</h1>

                <a href="{{ route('loans.create') }}"
                   class="bg-purple-500 px-4 py-2 rounded-lg hover:scale-105 transition">
                    + Issue Loan
                </a>
            </div>

            <!-- FILTER -->
            <form method="GET" class="flex gap-3 max-w-sm">
                <select name="status"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg p-2 text-sm">

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

                <button class="bg-indigo-500 px-4 py-2 rounded-lg text-sm">
                    Filter
                </button>
            </form>

            <!-- TABLE -->
            <div class="bg-gray-800 rounded-xl overflow-hidden">

                <table class="w-full text-sm">
                    <thead class="bg-gray-900 text-gray-400">
                        <tr>
                            <th class="p-3 text-left">Loan</th>
                            <th class="p-3 text-left">Member</th>
                            <th class="p-3 text-left">Product</th>
                            <th class="p-3 text-left">Due</th>
                            <th class="p-3 text-right">Balance</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-gray-900">

                                <td class="p-3">
                                    <p class="font-medium">{{ $loan->loan_no }}</p>
                                    <p class="text-xs text-gray-400">
                                        KES {{ number_format($loan->principal, 2) }}
                                    </p>
                                </td>

                                <td class="p-3">{{ $loan->member->full_name }}</td>

                                <td class="p-3">{{ $loan->product->name }}</td>

                                <td class="p-3 text-gray-400">
                                    {{ optional($loan->due_on)->format('M d, Y') }}
                                </td>

                                <td class="p-3 text-right font-semibold text-green-400">
                                    {{ number_format($loan->balance, 2) }}
                                </td>

                                <td class="p-3">
                                    <span class="text-xs px-2 py-1 rounded
                                        @if($loan->status === 'pending') bg-yellow-500/20 text-yellow-300
                                        @elseif($loan->status === 'approved') bg-blue-500/20 text-blue-300
                                        @elseif($loan->status === 'disbursed') bg-green-500/20 text-green-300
                                        @elseif($loan->status === 'completed') bg-gray-500/20 text-gray-300
                                        @elseif($loan->status === 'rejected') bg-red-500/20 text-red-300
                                        @endif
                                    ">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>

                                <td class="p-3 text-right">
                                    <div class="flex justify-end gap-3 text-sm">

                                        <a href="{{ route('loans.show', $loan) }}"
                                           class="text-indigo-400 hover:underline">
                                            Open
                                        </a>

                                        @if($loan->isPending())
                                            <form method="POST" action="{{ route('loans.approve', $loan) }}">
                                                @csrf
                                                <button class="text-blue-400 hover:underline">
                                                    Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('loans.reject', $loan) }}">
                                                @csrf
                                                <button class="text-red-400 hover:underline">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        @if($loan->isApproved())
                                            <form method="POST" action="{{ route('loans.disburse', $loan) }}">
                                                @csrf
                                                <button class="text-green-400 hover:underline">
                                                    Disburse
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400">
                                    No loans found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <div class="p-4 border-t border-gray-700">
                    {{ $loans->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>