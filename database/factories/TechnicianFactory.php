<?php

namespace Database\Factories;

use App\Models\Counter;
use App\Models\User;
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
        $randomLetter = $this->faker->lexify();
        $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter . $randomnumber);
        return [
            'id' => $id,
            'user_id' => User::inRandomOrder()->first()->id,
            'counter_id' => Counter::inRandomOrder()->first()->id
        ];
    }
}
