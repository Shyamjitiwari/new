<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create(['country_name'=>'USA', 'calling_code' => '+1', 'character_code' => 'US']);
        Country::create(['country_name'=>'France', 'calling_code' => '+33', 'character_code' => 'FR']);
        Country::create(['country_name'=>'Switzerland', 'calling_code' => '+41', 'character_code' => 'CH']); 
        Country::create(['country_name'=>'Pakistan', 'calling_code' => '+92', 'character_code' => 'PK']);
        Country::create(['country_name'=>'India', 'calling_code' => '+91', 'character_code' => 'IN']);
    }
}
