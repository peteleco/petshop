<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::factory()->waiting()->create();
        OrderStatus::factory()->processing()->create();
        OrderStatus::factory()->paymentFailed()->create();
        OrderStatus::factory()->inProgress()->create();
        OrderStatus::factory()->completed()->create();
        OrderStatus::factory()->canceled()->create();
    }
}
