<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PricingRule>
 */
class PricingRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ruleTypes = ['season', 'weekend', 'event', 'demand'];
        $valueTypes = ['percentage', 'fixed'];

        return [
            'rule_type' => $this->faker->randomElement($ruleTypes),
            'name' => $this->faker->word() . 'rule',
            'value' => $this->faker->numberBetween(5, 30),
            'value_type' => $this->faker->randomElement($valueTypes),
            'start_date' => now()->subDays(rand(0,10)),
            'end_date' => now()->addDays(rand(10,30)), 
        ];
    }
}
