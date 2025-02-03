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
        $randomLetter = $this->faker->unique()->lexify();
        // $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter);
        return [
            'id' => $id,
            'type_phone' => $this->faker->sentence(4),
            'merk_phone' => $this->faker->sentence(2),
            'created_at' => now(),
            'created_by' => 'Migrations',
            'updated_at' => NULL,
            'updated_by' => NULL,
            'deleted_at' => NULL,
            'deleted_by' => NULL,
        ];
    }
}
