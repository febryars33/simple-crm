<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory(1)->create();

        Admin::factory(1)->create();

        User::factory()->create([
            'userable_id' => 1,
            'userable_type' => Admin::class,
            'name' => fake()->name(),
            'email' => 'administrator@localhost',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'userable_id' => 2,
            'userable_type' => Employee::class,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
