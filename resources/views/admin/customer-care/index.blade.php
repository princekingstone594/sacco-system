<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase text-[#947b2f]">Admin</p>
                <h1 class="text-2xl font-extrabold text-[#241f2f]">Customer Care Enquiries</h1>
            </div>
            <form method="GET" action="{{ route('admin.customer-care.index') }}">
                <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <section class="rounded-lg border border-[#ded8c8] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#eee8dc] text-sm">
                <thead class="bg-[#f8f6f1] text-left text-xs font-bold uppercase text-[#716a7c]">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Submitted</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eee8dc]">
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-[#241f2f]">{{ $inquiry->name }}</p>
                                <p class="text-xs text-[#716a7c]">{{ $inquiry->email }} {{ $inquiry->phone ? ' | '.$inquiry->phone : '' }}</p>
                            </td>
                            <td class="px-4 py-3 font-semibold text-[#241f2f]">{{ $inquiry->subject }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-[#f6f1e6] px-3 py-1 text-xs font-bold text-[#4b2673]">
                                    {{ $statuses[$inquiry->status] ?? ucfirst($inquiry->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#716a7c]">{{ $inquiry->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.customer-care.show', $inquiry) }}" class="font-bold text-[#4b2673] hover:underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[#716a7c]">No enquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($inquiries->hasPages())
            <div class="border-t border-[#eee8dc] px-4 py-3">
                {{ $inquiries->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
