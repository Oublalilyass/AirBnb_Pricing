<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'location' => $this->faker->city(),
            'base_price' => $this->faker->numberBetween(40,800),
            'min_price' => 40,
            'max_price' => 800,
        ];
    }
}
