<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Suki ni Payot', 'Budget Meal', 'Halal', 'Open 24 Hours', 'Aircon', 'Free Wi-Fi'] as $name) {
            Feature::create(['name' => $name]);
        }
    }
}