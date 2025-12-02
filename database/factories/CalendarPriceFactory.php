<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CalendarPrice;
use App\Models\Listing;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarPrice>
 */
class CalendarPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CalendarPrice::class;

    public function definition(): array
    {
        return [
            'listing_id'       => Listing::inRandomOrder()->first()->id ?? Listing::factory()->create()->id,
            'date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'calculated_price' => $this->faker->numberBetween(60, 400),
        ];
    }
}
