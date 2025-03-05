<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebsiteView>
 */
class WebsiteViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'num' => rand(1, 100),
            'ip' => $this->faker->ipv4,
            'date' => $this->faker->dateTimeBetween('-10 days'),
        ];
    }
}
