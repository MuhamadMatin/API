<?php

namespace Database\Factories;

use App\Models\Counter;
use App\Models\User;
use App\Models\Damage;
use App\Models\Phone;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\Technician;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
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
            // 'slug' => Str::slug($this->faker->unique->name()),
            'subtotal' => $this->faker->randomFloat(2, 100, 1000),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['Service', 'Waiting Service', 'Done', 'Waiting owner']),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
            'phone_id' => Phone::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'technician_id' => Technician::inRandomOrder()->first()->id,
            'damage_id' => Damage::inRandomOrder()->first()->id,
            'counter_id' => Counter::inRandomOrder()->first()->id,
            'sparepart_id' => Sparepart::inRandomOrder()->first()->id,
            'start_waranty' => $this->faker->dateTimeBetween('now'),
            'end_waranty' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
