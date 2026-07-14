<x-app-layout>
    <x-slot name="header">
        Members
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white p-6">

        <div class="max-w-6xl mx-auto space-y-6">

            <!-- HEADER -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">Members</h1>

                <div class="flex gap-2">
                    <a href="{{ route('members.create') }}"
                       class="bg-indigo-500 px-4 py-2 rounded-lg hover:scale-105 transition">
                        + Add Member
                    </a>

                    <a href="{{ route('members.wallet') }}"
                       class="bg-gray-700 px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        💼 Wallet
                    </a>
                </div>
            </div>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="bg-green-500/20 text-green-300 p-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="bg-gray-800 rounded-xl overflow-hidden">

                <table class="w-full text-sm">
                    <thead class="bg-gray-900 text-gray-400">
                        <tr>
                            <th class="p-3 text-left">Member No</th>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Phone</th>
                            <th class="p-3 text-left">Savings</th>
                            <th class="p-3 text-left">Loans</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700">
                        @forelse($members as $member)
                            <tr class="hover:bg-gray-900">

                                <td class="p-3">{{ $member->member_no }}</td>

                                <td class="p-3 font-medium">
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </td>

                                <td class="p-3">{{ $member->id_number }}</td>

                                <td class="p-3">{{ $member->phone }}</td>

                                <td class="p-3 text-green-400">
                                    KES {{ number_format($member->accounts_sum_balance ?? 0) }}
                                </td>

                                <td class="p-3">
                                    {{ $member->loans_count }}
                                </td>

                                <td class="p-3">
                                    @if($member->is_active)
                                        <span class="text-green-400">Active</span>
                                    @else
                                        <span class="text-red-400">Inactive</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400">
                                    No members yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>