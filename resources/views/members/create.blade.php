<x-app-layout>
    <x-slot name="header">
        Add Member
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-sm">

        <form method="POST" action="{{ route('members.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Member No</label>
                    <input type="text" name="member_no" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="text-sm">Join Date</label>
                    <input type="date" name="joined_at" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="text-sm">First Name</label>
                    <input type="text" name="first_name" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="text-sm">Last Name</label>
                    <input type="text" name="last_name" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="text-sm">National ID</label>
                    <input type="text" name="national_id" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="text-sm">Phone</label>
                    <input type="text" name="phone" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div class="col-span-2">
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" class="w-full mt-1 rounded-lg border-gray-300">
                </div>

                <div class="col-span-2">
                    <label class="text-sm">Status</label>
                    <select name="status" class="w-full mt-1 rounded-lg border-gray-300">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>

            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                Save Member
            </button>
        </form>

    </div>
</x-app-layout>