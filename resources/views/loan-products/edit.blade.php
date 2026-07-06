<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Loan Product</h2></x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('loan-products.update', $product) }}" class="rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
                @method('PATCH')
                @include('loan-products._form')
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('loan-products.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                    <x-primary-button>Update Product</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
