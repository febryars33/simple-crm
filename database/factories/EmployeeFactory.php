<?php

namespace Database\Factories;

use App\Enums\Employee\Role;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        usleep(250000);
        return [
            'company_id' => Company::factory(),
            'name' => fake()->name(),
            'nik' => fake()->unique()->numerify('################'),
            'phone' => fake()->unique()->numerify('0873########'),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '2000-01-01'),
            'address' => fake()->address(),
            'role' => Role::MANAGER->value,
        ];
    }
}
