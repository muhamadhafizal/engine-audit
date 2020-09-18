<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class EnergySource extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('energysources')->insert([
            'name' => 'Anthracite',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Aviation gasonline',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Biodiesels',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Biogasonline',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Bitumen',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Blast furnace gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Brown coal briquettes',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Charcoal',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Coal tar',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Coke over coke',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Cooking coal',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Crude oil',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Electricty',
            'category' => 'Electricty',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Ethane',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Gas coke',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Gas works gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Gas /Diesel oil',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Industrial waste',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Jet gasonline',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Jet kerosene',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Landfill gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Lignite',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Lignite coke',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'LPG',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Lubricants',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Motor gasonline',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Municipal waste (Non biomass fraction)',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Municipal waste (Biomass fraction)',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Naphtha',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Natural gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Natural gas liquids',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Oil shale and tar sands',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Orimulsion',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other biogas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other butiminios coal',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other kerosene',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other liquids biofuels',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other petroleum product',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Other primary solid biomass fuels',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Oxygen steels furnace gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Paraffin waxes',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Patent fuel',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Peat',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Petroleum coke',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Refinery feedstocks',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Refinery gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Residual fuel oil',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Shale oil',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Sludges gas',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Sub butiminous coal',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Sulphite Iyes (Black liquor)',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Waste Oils',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'White Spirit / SBP',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('energysources')->insert([
            'name' => 'Wood or Wood waste',
            'category' => 'Thermal',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
    }
}
