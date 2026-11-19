<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->lastName() . "'s Eatery";

        return [
            'district_id' => District::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement(['Tinola', 'Kinilaw', 'Sinugbang Isda', 'Adobo', 'Pancit', 'Lechon Manok']),
            'is_open' => true,
        ];
    }

    // closed state: same eatery but not open
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => ['is_open' => false]);
    }
}