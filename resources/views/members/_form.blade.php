@csrf
<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="member_no" value="Member Number" />
        <x-text-input id="member_no" name="member_no" class="mt-1 block w-full" value="{{ old('member_no', $member->member_no) }}" required />
        <x-input-error :messages="$errors->get('member_no')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="joined_at" value="Joined Date" />
        <x-text-input id="joined_at" name="joined_at" type="date" class="mt-1 block w-full" value="{{ old('joined_at', optional($member->joined_at)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required />
        <x-input-error :messages="$errors->get('joined_at')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="first_name" value="First Name" />
        <x-text-input id="first_name" name="first_name" class="mt-1 block w-full" value="{{ old('first_name', $member->first_name) }}" required />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="last_name" value="Last Name" />
        <x-text-input id="last_name" name="last_name" class="mt-1 block w-full" value="{{ old('last_name', $member->last_name) }}" required />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="national_id" value="National ID" />
        <x-text-input id="national_id" name="national_id" class="mt-1 block w-full" value="{{ old('national_id', $member->national_id) }}" />
        <x-input-error :messages="$errors->get('national_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="phone" value="Phone" />
        <x-text-input id="phone" name="phone" class="mt-1 block w-full" value="{{ old('phone', $member->phone) }}" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $member->email) }}" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="date_of_birth" value="Date of Birth" />
        <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" value="{{ old('date_of_birth', optional($member->date_of_birth)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="employer" value="Employer" />
        <x-text-input id="employer" name="employer" class="mt-1 block w-full" value="{{ old('employer', $member->employer) }}" />
        <x-input-error :messages="$errors->get('employer')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $member->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="next_of_kin_name" value="Next of Kin Name" />
        <x-text-input id="next_of_kin_name" name="next_of_kin_name" class="mt-1 block w-full" value="{{ old('next_of_kin_name', $member->next_of_kin_name) }}" />
        <x-input-error :messages="$errors->get('next_of_kin_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="next_of_kin_phone" value="Next of Kin Phone" />
        <x-text-input id="next_of_kin_phone" name="next_of_kin_phone" class="mt-1 block w-full" value="{{ old('next_of_kin_phone', $member->next_of_kin_phone) }}" />
        <x-input-error :messages="$errors->get('next_of_kin_phone')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="address" value="Address" />
        <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $member->address) }}</textarea>
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>
</div>
