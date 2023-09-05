<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->getKey(),
            'order_status_id' => OrderStatus::query()->where('title', 'like', '%Waiting%')->limit(1)->get()->first()->getKey(),
            'payment_id' => Payment::query()->limit(1)->first()->getKey(),
            'products' => '[]',
            'address' => '{}',
            'delivery_fee' => null,
            'amount' => 15,
             'shipped_at' => null,

        ];
    }
}
