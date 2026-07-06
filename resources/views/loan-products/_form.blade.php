@csrf
<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <x-input-label for="name" value="Product Name" />
        <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $product->name) }}" required />
    </div>
    <div>
        <x-input-label for="interest_rate" value="Interest Rate (%)" />
        <x-text-input id="interest_rate" name="interest_rate" type="number" min="0" max="100" step="0.01" class="mt-1 block w-full" value="{{ old('interest_rate', $product->interest_rate) }}" required />
    </div>
    <div>
        <x-input-label for="term_months" value="Term (Months)" />
        <x-text-input id="term_months" name="term_months" type="number" min="1" class="mt-1 block w-full" value="{{ old('term_months', $product->term_months) }}" required />
    </div>
    <div>
        <x-input-label for="minimum_amount" value="Minimum Amount" />
        <x-text-input id="minimum_amount" name="minimum_amount" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('minimum_amount', $product->minimum_amount ?? 0) }}" required />
    </div>
    <div>
        <x-input-label for="maximum_amount" value="Maximum Amount" />
        <x-text-input id="maximum_amount" name="maximum_amount" type="number" min="0" step="0.01" class="mt-1 block w-full" value="{{ old('maximum_amount', $product->maximum_amount) }}" />
    </div>
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $product->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
    </div>
</div>
