<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        // my own eatery, made by hand
        $name = 'Carinderia ni Payot';
        $mine = Eatery::create([
            'district_id' => District::where('name', 'Poblacion')->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $mine->features()->sync(
            Feature::whereIn('name', ['Suki ni Payot', 'Budget Meal'])->pluck('id')->all()
        );

        $mine->permit()->create([
            'permit_no' => 'DVO-2026-0520',
            'expires_on' => '2027-05-20',
        ]);

        $mine->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);

        // 14 more eateries from the factory, the last 3 are closed
        $featureIds = Feature::pluck('id');

        for ($i = 1; $i <= 14; $i++) {
            $eatery = $i > 11
                ? Eatery::factory()->closed()->create()
                : Eatery::factory()->create();

            // the first one gets an expired permit so "Permit expired" can be shown
            $permit = $i === 1
                ? Permit::factory()->make(['expires_on' => now()->subMonths(2)])
                : Permit::factory()->make();
            $eatery->permit()->save($permit);

            Dish::factory()->count(rand(2, 5))->create(['eatery_id' => $eatery->id]);

            $eatery->features()->attach($featureIds->random(rand(1, 3))->all());
        }
    }
}