<x-app-layout>
    <x-slot name="header">
        Members
    </x-slot>

    <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-semibold">All Members</h2>

        <a href="{{ route('members.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            + Add Member
        </a>

        <a href="{{ route('members.wallet') }}"
           class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">
            💼 Member Wallet
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-4">Member No</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">ID Number</th>
                    <th class="p-4">Phone</th>
                    <th class="p-4">Loans</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                    <tr class="border-t">
                        <td class="p-4">{{ $member->member_no }}</td>
                        <td class="p-4">{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td class="p-4">{{ $member->id_number }}</td>
                        <td class="p-4">{{ $member->phone }}</td>
                        <td class="p-4">KES {{ number_format($member->accounts_sum_balance ?? 0) }}</td>
                        <td class="p-4"> {{ $member->loans_count }} </td>
                        <td class="p-4">
                            @if($member->is_active)
                                <span class="text-green-600">Active</span>
                            @else
                                <span class="text-red-500">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            No members yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>