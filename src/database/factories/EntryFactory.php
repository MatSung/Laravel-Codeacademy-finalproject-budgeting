<?php

namespace Database\Factories;

use App\Models\EntryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_date' => fake()->dateTimeBetween('-2 weeks'),
            'category_id'=> EntryCategory::factory(),
            'amount' => fake()->randomFloat(2, -100, 100),
            'note' => fake()->word(),
        ];
    }
}
