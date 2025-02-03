<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Counter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technician>
 */
class TechnicianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomLetter = $this->faker->unique()->lexify();
        // $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter);
        return [
            'id' => $id,
            'user_id' => User::inRandomOrder()->first()->id,
            'counter_id' => Counter::inRandomOrder()->first()->id,
            'created_at' => now(),
            'created_by' => 'Migrations',
            'updated_at' => NULL,
            'updated_by' => NULL,
            'deleted_at' => NULL,
            'deleted_by' => NULL,
        ];
    }
}
