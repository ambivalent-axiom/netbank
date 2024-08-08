<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(
        string $type = null,
        string $symbol = null,
        float $rate = null,
        string $logo = null,
        string $name = null,
        int $rank = null,
        float $percent_changed = null,
    ): array
    {
        return [
            'type' => $type ?? $this->faker->randomElement(['fiat', 'crypto']),
            'symbol' => $symbol ?? $this->faker->currencyCode(),
            'rate' => $rate ?? rand(0, 100),
            'logo' => $logo ?? $this->faker->imageUrl(),
            'name' => $name ?? $this->faker->name(),
            'rank' => $rank ?? $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'percent_changed' => $percent_changed ?? $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        ];
    }
}
