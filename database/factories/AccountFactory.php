<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Uuid;

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
    public function definition(
        string $type = null,
        string $currency = null,
        int $user_id = null,
        int $balance = null
    ): array
    {
        return [
            'id' => Uuid::uuid4(),
            'type' => $type ?? 'private',
            'portfolio_id' => null,
            'currency' => $currency ?? Arr::random(['EUR', 'USD']),
            'user_id' => $user_id ?? User::all()->random()->id,
            'balance' => $balance ?? random_int(0, 1000),
        ];
    }
}
