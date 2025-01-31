<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Phone;
use App\Models\Damage;
use App\Models\Counter;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\Technician;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 'ADM000001',
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('passwordadmin'),
        ]);
        Counter::factory(100)->create();
        Phone::factory(1000)->create();
        Damage::factory(5000)->create();
        Sparepart::factory(15000)->create();
        User::factory(1000)->create();
        Technician::factory(150)->create();
        Service::factory(50000)->create();
        // Damage::factory(100)->create()->each(function ($damage) {
        //     $service = Service::factory()->create([
        //         'damage_id' => $damage->id,
        //     ]);
        //     $damage->update(['service_id' => $service->id]);
        // });
        // Service::factory(100)->create();
    }
}
