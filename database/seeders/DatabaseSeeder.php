<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\NewsArticle;
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
        $user1 = User::factory()->create([
            'first_name' => 'Artūrs',
            'last_name' => 'Melnis',
            'email' => 'artmelnis@gmail.com',
            'type' => 'private',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        $user2 = User::factory()->create([
            'first_name' => 'Evelīna',
            'last_name' => 'Melne',
            'email' => 'evelina.melne@gmail.com',
            'type' => 'private',
            'default_account' => null,
            'password' => Hash::make('qwerty123'),
        ]);
        $account1 = Account::factory()->create([
            'user_id' => $user1->id,
        ]);
        $account2 = Account::factory()->create([
            'user_id' => $user2->id,
        ]);
        $user1->update([
            'default_account' => $account1->id,
        ]);
        $user2->update([
            'default_account' => $account2->id,
        ]);
        NewsArticle::factory(2)->create();
    }
}
