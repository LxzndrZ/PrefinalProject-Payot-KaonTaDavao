<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Alexzander Rojan Payot',
            'email' => 'payot@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::create([
            'name' => 'Tita Payot',
            'email' => 'tita.payot@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        // 10 more users from the factory
        User::factory()->count(10)->create();
    }
}