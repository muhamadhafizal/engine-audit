<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class AirconditioningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airconditionings')->insert([
            'actype' => 'Wall-mounted',
            'refrigerant' => 'R-410A',
            'inverter' => 'Inverter',
            'rating' => 'No rating',
            'controlsystem' => 'Manual',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('airconditionings')->insert([
            'actype' => 'Cassette',
            'refrigerant' => 'R-22',
            'inverter' => 'Non-inverter',
            'rating' => '1',
            'controlsystem' => 'Timer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('airconditionings')->insert([
            'actype' => 'Portable',
            'refrigerant' => 'R-125',
            'inverter' => '',
            'rating' => '2',
            'controlsystem' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('airconditionings')->insert([
            'actype' => 'Ceiling-concealed',
            'refrigerant' => 'R-32',
            'inverter' => '',
            'rating' => '3',
            'controlsystem' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
