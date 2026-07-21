<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SavingPortfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SavingPortfolioController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $member = auth()->user()->member;

        if (! $member) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Complete your member profile before creating a saving portfolio.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', Rule::in(array_keys(SavingPortfolio::CATEGORIES))],
            'target_amount' => ['nullable', 'numeric', 'min:1'],
            'target_date' => ['nullable', 'date', 'after:today'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($member, $data) {
            $sequence = SavingPortfolio::where('member_id', $member->id)->count() + 1;

            $account = Account::create([
                'member_id' => $member->id,
                'account_no' => 'POR-'.$member->member_no.'-'.str_pad((string) $sequence, 2, '0', STR_PAD_LEFT),
                'type' => 'portfolio',
                'opened_at' => now(),
                'status' => 'active',
            ]);

            SavingPortfolio::create([
                'member_id' => $member->id,
                'account_id' => $account->id,
                'name' => $data['name'],
                'category' => $data['category'],
                'target_amount' => $data['target_amount'] ?? null,
                'target_date' => $data['target_date'] ?? null,
                'description' => $data['description'] ?? null,
                'status' => 'active',
            ]);
        });

        return redirect()
            ->to(route('dashboard').'#our-products')
            ->with('success', 'Your saving portfolio has been created. Start contributing toward your goal!');
    }
}
