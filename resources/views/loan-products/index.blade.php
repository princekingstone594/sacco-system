<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Loan Products</h2>
            <a href="{{ route('loan-products.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Create Product</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Product</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Rate</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Term</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Limits</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Loans</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-5 py-4"><p class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</p><p class="text-sm capitalize text-gray-500">{{ $product->status }}</p></td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $product->interest_rate }}%</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $product->term_months }} months</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ number_format($product->minimum_amount, 2) }} - {{ $product->maximum_amount ? number_format($product->maximum_amount, 2) : 'No cap' }}</td>
                                <td class="px-5 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">{{ $product->loans_count }}</td>
                                <td class="px-5 py-4 text-right"><a href="{{ route('loan-products.edit', $product) }}" class="text-sm font-medium text-indigo-600">Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No loan products yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t border-gray-100 p-4 dark:border-gray-700">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
