<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PositionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->jobTitle(),
            // because now only 1 admin
            'admin_created_id' => 1,
            'admin_updated_id' => 1,

            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
