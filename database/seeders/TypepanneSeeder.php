<?php

namespace Database\Seeders;

use App\Models\Typepanne;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypepanneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Typepanne::create(['name' => 'Entretien']);
        Typepanne::create(['name' => 'Moteur thermique']);
        Typepanne::create(['name' => 'Transmission']);
        Typepanne::create(['name' => 'Pneumatique']);
        Typepanne::create(['name' => "Boite de vitesse"]);
        Typepanne::create(['name' => "Pièces d'usure"]);
        Typepanne::create(['name' => "Incident mine"]);
        Typepanne::create(['name' => "Attente PDR"]);
        Typepanne::create(['name' => "Convertisseur de couple"]);
    }
}