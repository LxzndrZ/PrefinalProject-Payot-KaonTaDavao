<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $mine = Eatery::where('slug', 'carinderia-ni-payot')->first();
        $tita = User::where('email', 'tita.payot@kaonta.test')->first();
        $me = User::where('email', 'payot@kaonta.test')->first();

        // 3 reviews on my eatery, one by Tita
        $mine->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Payot.',
        ]);
        $mine->reviews()->create([
            'user_id' => $me->id,
            'rating' => 4,
            'body' => 'Sulit ang tinola, init pa jud pag serve.',
        ]);
        $mine->reviews()->create([
            'user_id' => $users->random()->id,
            'rating' => 5,
            'body' => 'Best durian shake sa Poblacion, balik ko ugma.',
        ]);

        // 0 to 6 reviews on every other open eatery, closed ones get none
        Eatery::where('is_open', true)->where('id', '!=', $mine->id)->get()->each(function ($eatery) use ($users) {
            Review::factory()
                ->count(rand(0, 6))
                ->sequence(fn ($seq) => ['user_id' => $users->random()->id])
                ->create(['eatery_id' => $eatery->id]);
        });
    }
}