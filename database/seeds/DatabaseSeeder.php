<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // EnergySource::class,
            // LoggingSeeder::class,
            //TypeoflightSeeder::class,
            //LightingcontrolSeeder::class,
            //AirconditioningSeeder::class,
            LightingSeeder::class,
        ]);
    }
}
