<?php

namespace Database\Factories;

use App\Enums\PaymentType;
use App\ValueObjects\Payment\BankTransfer;
use App\ValueObjects\Payment\CashOnDelivery;
use App\ValueObjects\Payment\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function creditCard(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => PaymentType::CreditCard,
            'details' => CreditCard::jsonSchema(),
        ]);
    }

    public function bankTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => PaymentType::BankTransfer,
            'details' => BankTransfer::jsonSchema(),
        ]);
    }

    public function cashOnDelivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => PaymentType::CashOnDelivery,
            'details' => CashOnDelivery::jsonSchema(),
        ]);
    }
}
