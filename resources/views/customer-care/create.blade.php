<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold uppercase text-[#947b2f]">Support</p>
            <h1 class="text-2xl font-extrabold text-[#241f2f]">Customer Care</h1>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#241f2f]">Contact Details</h2>
            <div class="mt-4 space-y-3 text-sm">
                <div>
                    <p class="font-bold text-[#716a7c]">Name</p>
                    <p class="text-[#241f2f]">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="font-bold text-[#716a7c]">Email</p>
                    <p class="text-[#241f2f]">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="font-bold text-[#716a7c]">Phone</p>
                    <p class="text-[#241f2f]">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="font-bold text-[#716a7c]">Location</p>
                    <p class="text-[#241f2f]">{{ $user->location ?? '-' }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-[#ded8c8] bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#241f2f]">Send an Enquiry</h2>

            @if (session('success'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer-care.store') }}" class="mt-5 space-y-4">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="subject" value="Subject" />
                        <x-text-input id="subject" name="subject" class="mt-1 block w-full" :value="old('subject')" required />
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="message" value="Question or Enquiry" />
                    <textarea id="message" name="message" rows="7" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>

                <x-primary-button>Submit Enquiry</x-primary-button>
            </form>
        </section>
    </div>
</x-app-layout>
