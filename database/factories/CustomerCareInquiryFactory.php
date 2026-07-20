<?php

namespace Database\Factories;

use App\Models\CustomerCareInquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerCareInquiry>
 */
class CustomerCareInquiryFactory extends Factory
{
    protected $model = CustomerCareInquiry::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(),
            'status' => 'open',
        ];
    }
}
