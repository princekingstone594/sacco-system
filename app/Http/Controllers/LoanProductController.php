<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LoanProductController extends Controller
{
    public function index(): View
    {
        return view('loan-products.index', [
            'products' => LoanProduct::withCount('loans')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('loan-products.create', ['product' => new LoanProduct()]);
    }

    public function store(Request $request): RedirectResponse
    {
        LoanProduct::create($this->validated($request));

        return redirect()->route('loan-products.index')->with('success', 'Loan product created.');
    }

    public function edit(LoanProduct $loanProduct): View
    {
        return view('loan-products.edit', ['product' => $loanProduct]);
    }

    public function update(Request $request, LoanProduct $loanProduct): RedirectResponse
    {
        $loanProduct->update($this->validated($request, $loanProduct));

        return redirect()->route('loan-products.index')->with('success', 'Loan product updated.');
    }

    public function destroy(LoanProduct $loanProduct): RedirectResponse
    {
        $loanProduct->delete();

        return redirect()->route('loan-products.index')->with('success', 'Loan product removed.');
    }

    private function validated(Request $request, ?LoanProduct $loanProduct = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('loan_products')->ignore($loanProduct?->id)],
            'interest_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'term_months' => ['required', 'integer', 'min:1', 'max:360'],
            'minimum_amount' => ['required', 'numeric', 'min:0'],
            'maximum_amount' => ['nullable', 'numeric', 'gte:minimum_amount'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}
