<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => $this->faker->company(),
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'url' => $this->faker->url(),
            'description' => $this->faker->text(),
            'content' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
