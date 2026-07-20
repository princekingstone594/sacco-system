<x-guest-layout>
    <div class="min-h-screen bg-[#f6f4ef] px-4 py-10">
        <div class="mx-auto w-full max-w-3xl rounded-lg border border-[#ded8c8] bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 text-center">
                <x-application-logo class="mx-auto h-16 w-16 rounded-lg object-contain" />
                <h1 class="mt-4 text-2xl font-extrabold text-[#4b2673]">Create your Royalty Sacco account</h1>
                <p class="mt-1 text-sm text-[#716a7c]">Your contact and profile details help us serve you faster.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Phone Number" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="location" value="Location" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required autocomplete="address-level2" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="national_id" value="National ID" />
                        <x-text-input id="national_id" name="national_id" type="text" class="mt-1 block w-full" :value="old('national_id')" />
                        <x-input-error :messages="$errors->get('national_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date_of_birth" value="Date of Birth" />
                        <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth')" />
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="occupation" value="Occupation" />
                        <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full" :value="old('occupation')" />
                        <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="profile_photo" value="Profile Picture" />
                        <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-gray-300 text-sm text-[#5f5968] file:mr-4 file:border-0 file:bg-[#4b2673] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                        <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label for="next_of_kin_name" value="Next of Kin Name" />
                        <x-text-input id="next_of_kin_name" name="next_of_kin_name" type="text" class="mt-1 block w-full" :value="old('next_of_kin_name')" />
                        <x-input-error :messages="$errors->get('next_of_kin_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="next_of_kin_phone" value="Next of Kin Phone" />
                        <x-text-input id="next_of_kin_phone" name="next_of_kin_phone" type="text" class="mt-1 block w-full" :value="old('next_of_kin_phone')" />
                        <x-input-error :messages="$errors->get('next_of_kin_phone')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="bio" value="Short Bio" />
                    <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio') }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-[#4b2673] hover:underline">Already have an account?</a>
                    <x-primary-button>Create Account</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
