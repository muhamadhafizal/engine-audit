<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class LoggingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loggings')->insert([
            'minute' => '0',
            'second' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('loggings')->insert([
            'minute' => '5',
            'second' => '5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('loggings')->insert([
            'minute' => '10',
            'second' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('loggings')->insert([
            'minute' => '15',
            'second' => '15',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('loggings')->insert([
            'minute' => '30',
            'second' => '30',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('loggings')->insert([
            'minute' => '60',
            'second' => '60',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
