<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name'              => 'User',
        //     'email'             => 'user@gmail.com',
        //     'email_verified_at' => now(),
        //     'password'          => Hash::make('12345678'),
        // ]);

        // $this->call(SiteSeeder::class);

        // $this->call(TypeparcSeeder::class);
        // \App\Models\Parc::factory(10)->create();
        // \App\Models\Engin::factory(10)->create();

        // $this->call(TypepanneSeeder::class);
        // \App\Models\Panne::factory(10)->create();

        // \App\Models\Saisierje::factory(10)->create();
    }
}