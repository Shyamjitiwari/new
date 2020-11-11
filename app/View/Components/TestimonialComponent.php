<?php

namespace App\View\Components;

use App\Testimonial;
use Illuminate\View\Component;

class TestimonialComponent extends Component
{
    

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $testimonials = Testimonial::active()->with(['image'])->get();
        return view('components.testimonial-component')->withTestimonials($testimonials);
    }
}
