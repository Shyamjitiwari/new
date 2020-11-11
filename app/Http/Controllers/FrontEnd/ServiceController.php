<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return Application|Factory|View
     */
    public function show($slug)
    {
        // if($slug == 'services-goal') {
        //     return view('frontend.services.services-goal');
        // } else if($slug == 'services-annual') {
        //     return view('frontend.services.services-annual');
        // } else if($slug == 'services-bigtkt') {
        //     return view('frontend.services.services-bigtkt');
        // } else if($slug == 'services-contingency') {
        //     return view('frontend.services.services-contingency');
        // } else if($slug == 'services-retirement') {
        //     return view('frontend.services.services-retirement');
        // } else if($slug == 'services-education') {
        //     return view('frontend.services.services-education');
        // }
        $service = Service::active()->where('slug',$slug)->first();
        return view('frontend.services.show')->withService($service);

    }
}
