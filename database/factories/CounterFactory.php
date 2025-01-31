<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Counter>
 */
class CounterFactory extends Factory
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
            'counter_name' => $this->faker->unique()->name(),
            'counter_address' => $this->faker->address(),
            'counter_phone' => $this->faker->phoneNumber(),
        ];
    }
}
