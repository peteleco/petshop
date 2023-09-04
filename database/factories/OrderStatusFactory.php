<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusFactory extends Factory
{
    protected $model = OrderStatus::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->text(255)
        ];
    }
    public function waiting(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('Waiting to be processed')
        ]);
    }
    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('Processing payment')
        ]);
    }
    public function paymentFailed(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('Payment failed')
        ]);
    }
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('In progress')
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('Completed')
        ]);
    }

    public function canceled(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => __('Canceled')
        ]);
    }

}
