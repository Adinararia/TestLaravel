<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees>
 */
class EmployeesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'reception' => fake()->date(),
            'phone' =>  fake('uk_UA')->phoneNumber(),
            'email' => fake()->email(),
            'salary' => fake()->randomFloat(3, 1, 500),
            'manager_id' => fake()->numberBetween(5, 50000),
            'position_id' => fake()->numberBetween(1, 50),
            'created_at' => now(),
            'updated_at' => now(),
            'admin_created_id' => 1,
            'admin_updated_id' => 1,

        ];
    }
}
