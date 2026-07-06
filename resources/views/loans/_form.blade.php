@csrf
<div class="grid gap-5 md:grid-cols-2">
    <div>
        <x-input-label for="loan_no" value="Loan Number" />
        <x-text-input id="loan_no" name="loan_no" class="mt-1 block w-full" value="{{ old('loan_no', $loan->loan_no) }}" required />
    </div>
    <div>
        <x-input-label for="issued_on" value="Issued On" />
        <x-text-input id="issued_on" name="issued_on" type="date" class="mt-1 block w-full" value="{{ old('issued_on', optional($loan->issued_on)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required />
    </div>
    <div>
        <x-input-label for="member_id" value="Member" />
        <select id="member_id" name="member_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="">Select member</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((int) old('member_id', $loan->member_id) === $member->id)>{{ $member->member_no }} - {{ $member->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="loan_product_id" value="Loan Product" />
        <select id="loan_product_id" name="loan_product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="">Select product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected((int) old('loan_product_id', $loan->loan_product_id) === $product->id)>{{ $product->name }} - {{ $product->interest_rate }}%, {{ $product->term_months }} months</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="principal" value="Principal" />
        <x-text-input id="principal" name="principal" type="number" min="1" step="0.01" class="mt-1 block w-full" value="{{ old('principal', $loan->principal) }}" required />
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach (['active' => 'Active', 'paid' => 'Paid', 'defaulted' => 'Defaulted', 'written_off' => 'Written Off'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $loan->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <x-input-label for="purpose" value="Purpose" />
        <textarea id="purpose" name="purpose" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('purpose', $loan->purpose) }}</textarea>
    </div>
</div>
