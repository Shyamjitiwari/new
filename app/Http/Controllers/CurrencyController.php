<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher|admin');
    }

    public function getAllCurrencies(){
        $currencies = Currency::all();

        return response()->json(['currencies'=> $currencies],200);
    }
}
