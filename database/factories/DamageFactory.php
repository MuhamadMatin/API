<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Damage>
 */
class DamageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name_damage = $this->faker->unique->name();
        $slug = Str::slug($name_damage);

        $randomLetter = $this->faker->lexify();
        $randomnumber = $this->faker->numberBetween();
        $id = strtoupper($randomLetter . $randomnumber);
        return [
            'id' => $id,
            'name' => $name_damage,
            // 'slug' => $slug,
            'price' => $this->faker->numberBetween(75000, 500000),
            'condition_description' => $this->faker->sentence(),
        ];
    }
}
