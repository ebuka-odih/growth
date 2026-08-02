<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('site.about', [
            'services' => Service::published()->ordered()->get(),
            'testimonials' => Testimonial::published()->ordered()->get(),
        ]);
    }
}
