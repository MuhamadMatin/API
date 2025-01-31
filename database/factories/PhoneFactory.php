<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phone>
 */
class PhoneFactory extends Factory
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
            'type_phone' => $this->faker->sentence(4),
            'merk_phone' => $this->faker->sentence(2)
        ];
    }
}
