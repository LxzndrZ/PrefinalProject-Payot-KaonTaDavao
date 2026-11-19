<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Pork Adobo', 'Chicken Inasal', 'Sinigang na Baboy', 'Pancit Canton', 'Lumpia', 'Halo-halo', 'Bulalo', 'Tapsilog']),
            'price' => fake()->randomFloat(2, 40, 300),
            'is_bestseller' => fake()->boolean(20),
        ];
    }
}