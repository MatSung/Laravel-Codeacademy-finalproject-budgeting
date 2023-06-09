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
            'transaction_date' => fake()->dateTimeBetween('-3 weeks')->format('Y-m-d H:i:s'),
            'category_id'=> EntryCategory::factory(),
            'amount' => fake()->randomFloat(2, -100, 100),
            'note' => fake()->words(5, true),
        ];
    }
}
