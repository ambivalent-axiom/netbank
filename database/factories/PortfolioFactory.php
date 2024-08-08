<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(
        string $id = null,
        int $user_id = null,
        string $symbol = null,
        string $name = null,
        float $amount = null,
    ): array
    {
        return [
            'portfolio_id' => $id ?? $this->faker->uuid(),
            'user_id' => $user_id ?? User::factory(),
            'symbol' => $this->faker->currencyCode(),
            'currency_name' => $this->faker->name(),
            'amount' => $this->faker->numberBetween(1000, 999999),
        ];
    }
}
