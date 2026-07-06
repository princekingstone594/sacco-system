<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $members = Member::withSum('accounts', 'balance')
            ->withCount('loans')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('member_no', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('national_id', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members', 'search'));
    }

    public function create(): View
    {
        return view('members.create', ['member' => new Member()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            $member = Member::create($data);

            foreach (Account::TYPES as $type => $label) {
                Account::create([
                    'member_id' => $member->id,
                    'account_no' => strtoupper(substr($type, 0, 3)).'-'.$member->member_no,
                    'type' => $type,
                    'opened_at' => $member->joined_at,
                    'status' => 'active',
                ]);
            }
        });

        return redirect()->route('members.index')->with('success', 'Member registered and accounts opened.');
    }

    public function show(Member $member): View
    {
        $member->load([
            'accounts.transactions' => fn ($query) => $query->latest('transacted_at')->take(5),
            'loans.product',
            'loans.repayments',
        ]);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $member->update($this->validated($request, $member));

        return redirect()->route('members.show', $member)->with('success', 'Member updated.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member removed.');
    }

    private function validated(Request $request, ?Member $member = null): array
    {
        $memberId = $member?->id;

        return $request->validate([
            'member_no' => ['required', 'string', 'max:50', Rule::unique('members')->ignore($memberId)],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'national_id' => ['nullable', 'string', 'max:100', Rule::unique('members')->ignore($memberId)],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:1000'],
            'employer' => ['nullable', 'string', 'max:150'],
            'next_of_kin_name' => ['nullable', 'string', 'max:150'],
            'next_of_kin_phone' => ['nullable', 'string', 'max:40'],
            'joined_at' => ['required', 'date'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ]);
    }
}
