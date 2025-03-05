<?php

namespace Database\Factories;

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
            'customer_id' => $this->faker->numberBetween(1, 10),
            'order_number' => $this->faker->uuid(),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'created_at' => $this->faker->dateTimeBetween('-10 days'),
            'payment_time' => $this->faker->dateTimeBetween('-10 days'),
        ];
    }
}
