<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saisierje>
 */
class SaisierjeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'daterje'   => fake()->dateTimeBetween($startDate = '-7 days', $interval = '+ 5 days', $timezone = null),
            'engin_id'  => rand(1, 4),
            'site_id'   => rand(1, 4),
            'panne_id'  => rand(1, 4),
            'hrm'       => rand(10, 24),
            'him'       => rand(2, 10),
            'nho'       => 24,
            'ni'        => rand(1, 8),
        ];
    }
}