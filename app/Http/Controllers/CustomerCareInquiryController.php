<?php

namespace App\Http\Controllers;

use App\Models\CustomerCareInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerCareInquiryController extends Controller
{
    public function create(): View
    {
        return view('customer-care.create', [
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        CustomerCareInquiry::create([
            ...$data,
            'user_id' => auth()->id(),
            'status' => 'open',
        ]);

        return redirect()->route('customer-care.create')
            ->with('success', 'Your enquiry has been sent to customer care.');
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $inquiries = CustomerCareInquiry::with(['user', 'responder'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.customer-care.index', [
            'inquiries' => $inquiries,
            'statuses' => CustomerCareInquiry::STATUSES,
            'status' => $status,
        ]);
    }

    public function show(CustomerCareInquiry $inquiry): View
    {
        $inquiry->load(['user', 'responder']);

        return view('admin.customer-care.show', [
            'inquiry' => $inquiry,
            'statuses' => CustomerCareInquiry::STATUSES,
        ]);
    }

    public function update(Request $request, CustomerCareInquiry $inquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(CustomerCareInquiry::STATUSES))],
            'admin_response' => ['nullable', 'string', 'max:5000'],
        ]);

        $inquiry->update([
            ...$data,
            'responded_by' => $data['admin_response'] ? auth()->id() : $inquiry->responded_by,
            'responded_at' => $data['admin_response'] ? now() : $inquiry->responded_at,
        ]);

        return redirect()->route('admin.customer-care.show', $inquiry)
            ->with('success', 'Customer-care enquiry updated.');
    }
}
