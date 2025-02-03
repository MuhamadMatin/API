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

        $randomLetter = $this->faker->unique()->lexify();
        // $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter);
        return [
            'id' => $id,
            'name' => $name_sparepart,
            // 'slug' => $slug,
            'price' => $this->faker->numberBetween(75000, 500000),
            'stock' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'created_by' => 'Migrations',
            'updated_at' => NULL,
            'updated_by' => NULL,
            'deleted_at' => NULL,
            'deleted_by' => NULL,
        ];
    }
}
