<?php

namespace App\Domain;
use App\Location;
use App\User;

class CreditsCalculations{
    public function calculateCredits($locationId){
        $location = Location::where('id',$locationId)->first();
        $users = $location->users()->get();

        return $users;
    }
}