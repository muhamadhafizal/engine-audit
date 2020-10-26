<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class LightingcontrolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lightingcontrols')->insert([
            'name' => 'Manual',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightingcontrols')->insert([
            'name' => 'Timer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightingcontrols')->insert([
            'name' => 'Motion',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightingcontrols')->insert([
            'name' => 'Photocell',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
