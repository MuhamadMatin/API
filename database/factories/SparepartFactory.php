<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sparepart>
 */
class SparepartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name_sparepart = $this->faker->unique->name();
        $slug = Str::slug($name_sparepart);

        $randomLetter = $this->faker->lexify();
        $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter . $randomnumber);
        return [
            'id' => $id,
            'name' => $name_sparepart,
            // 'slug' => $slug,
            'price' => $this->faker->numberBetween(75000, 500000),
            'stock' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence(),
        ];
    }
}
