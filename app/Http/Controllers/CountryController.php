<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin|parent');
    }

    public function getCountryCallingCode(){
        $countries = Country::all();
        $selectedCountry = Country::first()->value('id');

        return response()->json(['countryCallingCodes'=> $countries,'selectedCountry' =>$selectedCountry ],200);
    }
    public function getAllCountriesCallingCodes(){
        $countries = Country::all();
      
        return response()->json(['countriesCallingCodes'=> $countries],200);
    }
}
