<?php

namespace Database\Seeders;

use App\Enums\PaymentType;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::factory()->creditCard()->create();
        Payment::factory()->bankTransfer()->create();
        Payment::factory()->cashOnDelivery()->create();
    }
}
