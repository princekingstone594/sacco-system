<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase text-[#947b2f]">Customer Care</p>
                <h1 class="text-2xl font-extrabold text-[#241f2f]">{{ $inquiry->subject }}</h1>
            </div>
            <a href="{{ route('admin.customer-care.index') }}" class="rounded-md border border-[#ded8c8] px-4 py-2 text-sm font-bold text-[#4b2673] hover:bg-[#f6f1e6]">Back to Inbox</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <section class="space-y-6">
            <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
                <h2 class="text-lg font-extrabold text-[#241f2f]">Member Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="font-bold text-[#716a7c]">Name</dt>
                        <dd class="text-[#241f2f]">{{ $inquiry->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#716a7c]">Email</dt>
                        <dd class="text-[#241f2f]">{{ $inquiry->email }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#716a7c]">Phone</dt>
                        <dd class="text-[#241f2f]">{{ $inquiry->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#716a7c]">Registered Account</dt>
                        <dd class="text-[#241f2f]">{{ $inquiry->user?->email ?? 'Not linked' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
                <h2 class="text-lg font-extrabold text-[#241f2f]">Submitted Message</h2>
                <p class="mt-2 text-xs font-bold uppercase text-[#716a7c]">{{ $inquiry->created_at->format('M d, Y H:i') }}</p>
                <div class="mt-4 whitespace-pre-line rounded-md bg-[#f8f6f1] p-4 text-sm leading-6 text-[#241f2f]">{{ $inquiry->message }}</div>
            </div>
        </section>

        <section class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#241f2f]">Admin Response</h2>

            @if (session('success'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.customer-care.update', $inquiry) }}" class="mt-5 space-y-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" @selected(old('status', $inquiry->status) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="admin_response" value="Response Notes" />
                    <textarea id="admin_response" name="admin_response" rows="9" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('admin_response', $inquiry->admin_response) }}</textarea>
                    <x-input-error :messages="$errors->get('admin_response')" class="mt-2" />
                </div>

                @if ($inquiry->responded_at)
                    <p class="text-xs text-[#716a7c]">
                        Last response by {{ $inquiry->responder?->name ?? 'Admin' }} on {{ $inquiry->responded_at->format('M d, Y H:i') }}.
                    </p>
                @endif

                <x-primary-button>Save Response</x-primary-button>
            </form>
        </section>
    </div>
</x-app-layout>
