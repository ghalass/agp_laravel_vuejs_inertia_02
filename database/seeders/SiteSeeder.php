<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Site::create(['name' => 'PG11']);
        Site::create(['name' => 'TO14']);
        Site::create(['name' => 'MHDTT']);
        Site::create(['name' => 'PG10']);
        Site::create(['name' => 'FDRK']);
    }
}