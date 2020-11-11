<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQsController extends Controller
{
    public function getFAQsPage(){
        return view('faqs.admin_faqs');
    }
}
