<?php

use App\Models\CustomerCareInquiry;
use App\Models\User;

test('members can submit customer care enquiries', function () {
    $user = User::factory()->create([
        'phone' => '+254700000100',
        'location' => 'Nairobi',
    ]);

    $response = $this
        ->actingAs($user)
        ->post('/customer-care', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'subject' => 'Loan question',
            'message' => 'Can I repay my loan early?',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/customer-care');

    $this->assertDatabaseHas('customer_care_inquiries', [
        'user_id' => $user->id,
        'subject' => 'Loan question',
        'status' => 'open',
    ]);
});

test('admins can respond to customer care enquiries', function () {
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $inquiry = CustomerCareInquiry::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->patch("/admin/customer-care/{$inquiry->id}", [
            'status' => 'resolved',
            'admin_response' => 'Yes, early repayment is allowed.',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect("/admin/customer-care/{$inquiry->id}");

    $inquiry->refresh();

    expect($inquiry->status)->toBe('resolved')
        ->and($inquiry->responded_by)->toBe($admin->id)
        ->and($inquiry->responded_at)->not->toBeNull();
});
