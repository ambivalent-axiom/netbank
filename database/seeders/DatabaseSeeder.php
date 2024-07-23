<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Artūrs',
            'last_name' => 'Melnis',
            'email' => 'artmelnis@gmail.com',
            'type' => 'private',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        User::factory()->create([
            'first_name' => 'Egija',
            'last_name' => 'Melne',
            'email' => 'egija.melne@gmail.com',
            'type' => 'business',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        User::factory()->create([
            'first_name' => 'Evelīna',
            'last_name' => 'Melne',
            'email' => 'evelina.melne@gmail.com',
            'type' => 'private',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        User::factory()->create([
            'first_name' => 'Pāvels',
            'last_name' => 'Melnis',
            'email' => 'pavels.melne@gmail.com',
            'type' => 'private',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        Account::factory(10)->create();
    }
}
