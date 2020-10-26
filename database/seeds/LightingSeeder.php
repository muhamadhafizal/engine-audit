<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class LightingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lightings')->insert([
            'category' => 'Circulation area',
            'buildingareas' => 'Corridors,Passageway',
            'categorybuildingareas' => 'Circulation area--Corridors,Passageway',
            'lux' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Circulation area',
            'buildingareas' => 'Lift',
            'categorybuildingareas' => 'Circulation area--Lift',
            'lux' => '100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Circulation area',
            'buildingareas' => 'Stairs',
            'categorybuildingareas' => 'Circulation area--Stairs',
            'lux' => '100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Circulation area',
            'buildingareas' => 'Escalator',
            'categorybuildingareas' => 'Circulation area--Escalator',
            'lux' => '150',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Circulation area',
            'buildingareas' => 'External covered ways',
            'categorybuildingareas' => 'Circulation area--External covered ways',
            'lux' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Entrances',
            'buildingareas' => 'Entrance halls, lobbies, waiting rooms',
            'categorybuildingareas' => 'Entrances--Entrance halls, lobbies, waiting rooms',
            'lux' => '100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Entrances',
            'buildingareas' => 'Enquiry desk',
            'categorybuildingareas' => 'Entrances--Enquiry desk',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Entrances',
            'buildingareas' => 'Gate houses',
            'categorybuildingareas' => 'Entrances--Gate houses',
            'lux' => '200',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Kitchens',
            'buildingareas' => 'Food stores',
            'categorybuildingareas' => 'Kitchens--Food stores',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Kitchens',
            'buildingareas' => 'General',
            'categorybuildingareas' => 'Kitchens--General',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Outdoor',
            'buildingareas' => 'Controlled entrance halls or exit gates',
            'categorybuildingareas' => 'Outdoor--Controlled entrance halls or exit gates',
            'lux' => '100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Outdoor',
            'buildingareas' => 'Entrance and exit car park',
            'categorybuildingareas' => 'Outdoor--Entrance and exit car park',
            'lux' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Outdoor',
            'buildingareas' => 'Stores, stockyards',
            'categorybuildingareas' => 'Outdoor--Stores, stockyards',
            'lux' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Outdoor',
            'buildingareas' => 'Industrial covered ways',
            'categorybuildingareas' => 'Outdoor--Industrial covered ways',
            'lux' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Staff restaurants',
            'buildingareas' => 'Centre cafeterias,dining room',
            'categorybuildingareas' => 'Staff restaurants--Centre cafeterias,dining room',
            'lux' => '200',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Medical and first aids centres',
            'buildingareas' => 'Rest room',
            'categorybuildingareas' => 'Medical and first aids centres--Rest room',
            'lux' => '150',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Staff room',
            'buildingareas' => 'Changing locker and cleaners room, cloakrooms lavatories',
            'categorybuildingareas' => 'Staff room--Changing locker and cleaners room, cloakrooms lavatories',
            'lux' => '100',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Staff room',
            'buildingareas' => 'Restroom',
            'categorybuildingareas' => 'Staff room--Restroom',
            'lux' => '150',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Office',
            'buildingareas' => 'General office (clerical task & typing office)',
            'categorybuildingareas' => 'Office--General office (clerical task & typing office)',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Office',
            'buildingareas' => 'Deep plan general office',
            'categorybuildingareas' => 'Office--Deep plan general office',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Office',
            'buildingareas' => 'Business machine and typing',
            'categorybuildingareas' => 'Office--Business machine and typing',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Office',
            'buildingareas' => 'Filling room',
            'categorybuildingareas' => 'Office--Filling room',
            'lux' => '200',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Office',
            'buildingareas' => 'Conference room',
            'categorybuildingareas' => 'Office--Conference room',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Executive office',
            'categorybuildingareas' => 'Offices and shops--Executive office',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Computer rooms',
            'categorybuildingareas' => 'Offices and shops--Computer rooms',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Punch cards room',
            'categorybuildingareas' => 'Offices and shops--Punch cards room',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Drawing offices drawing boards',
            'categorybuildingareas' => 'Offices and shops--Drawing offices drawing boards',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Reference table and general',
            'categorybuildingareas' => 'Offices and shops--Reference table and general',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Offices and shops',
            'buildingareas' => 'Print room',
            'categorybuildingareas' => 'Offices and shops--Print room',
            'lux' => '400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'Conventional with counters',
            'categorybuildingareas' => 'Shop--Conventional with counters',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'Conventional with wall display',
            'categorybuildingareas' => 'Shop--Conventional with wall display',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'Self service',
            'categorybuildingareas' => 'Shop--Self service',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'Supermarkets',
            'categorybuildingareas' => 'Shop--Supermarkets',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'Hypermarkets',
            'categorybuildingareas' => 'Shop--Hypermarkets',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Shop',
            'buildingareas' => 'General',
            'categorybuildingareas' => 'Shop--General',
            'lux' => '750',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Further education establishment',
            'buildingareas' => 'Lecture theatres general',
            'categorybuildingareas' => 'Further education establishment--Lecture theatres general',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Further education establishment',
            'buildingareas' => 'Chalkboard',
            'categorybuildingareas' => 'Further education establishment--Chalkboard',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Further education establishment',
            'buildingareas' => 'Demonstration benches',
            'categorybuildingareas' => 'Further education establishment--Demonstration benches',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Further education establishment',
            'buildingareas' => 'Examination halls, seminar rooms, teaching spaces',
            'categorybuildingareas' => 'Further education establishment--Examination halls, seminar rooms, teaching spaces',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Further education establishment',
            'buildingareas' => 'Laboratories',
            'categorybuildingareas' => 'Further education establishment--Laboratories',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Shelves, book stack',
            'categorybuildingareas' => 'Libraries--Shelves, book stack',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Reading table',
            'categorybuildingareas' => 'Libraries--Reading table',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'reading rooms, newspaper and magazines',
            'categorybuildingareas' => 'Libraries--reading rooms, newspaper and magazines',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Reference libraries',
            'categorybuildingareas' => 'Libraries--Reference libraries',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Counters',
            'categorybuildingareas' => 'Libraries--Counters',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Cataloging and sorting',
            'categorybuildingareas' => 'Libraries--Cataloging and sorting',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Libraries',
            'buildingareas' => 'Binding',
            'categorybuildingareas' => 'Libraries--Binding',
            'lux' => '500',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'Museum and art galleries general',
            'buildingareas' => 'Light insensitive exhibits',
            'categorybuildingareas' => 'Museum and art galleries general--Light insensitive exhibits',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Assembly halls general',
            'categorybuildingareas' => 'School--Assembly halls general',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Teaching spaces general',
            'categorybuildingareas' => 'School--Teaching spaces general',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Chalkboard',
            'categorybuildingareas' => 'School--Chalkboard',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Beedlework rooms',
            'categorybuildingareas' => 'School--Beedlework rooms',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Laboratories',
            'categorybuildingareas' => 'School--Laboratories',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Workshop',
            'categorybuildingareas' => 'School--Workshop',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Gymnasium',
            'categorybuildingareas' => 'School--Gymnasium',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'School',
            'buildingareas' => 'Music practice rooms',
            'categorybuildingareas' => 'School--Music practice rooms',
            'lux' => '300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lightings')->insert([
            'category' => 'General',
            'buildingareas' => 'Changing rooms showers lookers rooms',
            'categorybuildingareas' => 'General--Changing rooms showers lookers rooms',
            'lux' => '150',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
