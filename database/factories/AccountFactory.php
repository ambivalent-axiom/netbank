<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Core\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => \Ramsey\Uuid\Uuid::uuid4(),
            'type' => 'private',
            'portfolio_id' => 0,
            'currency' => Arr::random(['EUR', 'USD']),
            'user_id' => User::all()->random()->id,
            'balance' => random_int(0, 1000),
        ];
    }
}
