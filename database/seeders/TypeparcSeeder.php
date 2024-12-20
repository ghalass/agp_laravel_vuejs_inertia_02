<?php

namespace Database\Seeders;

use App\Models\Typeparc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeparcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Typeparc::create(['name' => 'Roulage']);
        Typeparc::create(['name' => 'Terrssament']);
        Typeparc::create(['name' => 'Chargement Electrique']);
        Typeparc::create(['name' => 'Chargement Hydraulique']);
    }
}
