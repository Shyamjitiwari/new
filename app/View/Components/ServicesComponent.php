<?php

namespace App\View\Components;

use App\Service;
use Illuminate\View\Component;

class ServicesComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $services = Service::active()->with(['image'])->get();
        return view('components.services-component')->withServices($services);
    }
}
