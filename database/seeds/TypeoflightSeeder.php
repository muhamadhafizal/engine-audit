<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class TypeoflightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typeoflights')->insert([
            'typeoflight' => 'Compact fluorescent (CFL)',
            'averageefficacy' => '60',
            'colourrenderingindex' => 'Very Good',
            'typicalapplication' => 'Hotel, Shops, Homes, Offices',
            'typicallifespan' => '8000 - 10000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'Fluorescent',
            'averageefficacy' => '50',
            'colourrenderingindex' => 'Good w.r.t coating',
            'typicalapplication' => 'Offices, Shops, Hospitals, Homes',
            'typicallifespan' => '5000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'Halogen',
            'averageefficacy' => '20',
            'colourrenderingindex' => 'Excellent',
            'typicalapplication' => 'Exhibition grounds, Construction areas',
            'typicallifespan' => '2000 - 4000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'High pressure mercury (HPMV)',
            'averageefficacy' => '50',
            'colourrenderingindex' => 'Fair',
            'typicalapplication' => 'General lighting in factories, Garages, Car parking, Flood lighting',
            'typicallifespan' => '5000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'High pressure sodium (HPSV) SON',
            'averageefficacy' => '90',
            'colourrenderingindex' => 'Fair',
            'typicalapplication' => 'General lighting in factories, warehouses, Street lighting',
            'typicallifespan' => '6000 - 12000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'Incandescent',
            'averageefficacy' => '14',
            'colourrenderingindex' => 'Excellent',
            'typicalapplication' => 'Homes, Restaurants, General Lighting, Emergency lighting',
            'typicallifespan' => '1000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'Low pressure sodium (LPSV) SOX',
            'averageefficacy' => '150',
            'colourrenderingindex' => 'Poor',
            'typicalapplication' => 'Roadways, tunnels, canals, street lighting',
            'typicallifespan' => '6000 - 12000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('typeoflights')->insert([
            'typeoflight' => 'Light emitting diode (LED)',
            'averageefficacy' => '',
            'colourrenderingindex' => '',
            'typicalapplication' => '',
            'typicallifespan' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
