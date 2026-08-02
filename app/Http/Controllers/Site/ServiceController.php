<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('site.services.index', [
            'services' => Service::published()->ordered()->get(),
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_published, 404);

        return view('site.services.show', [
            'service' => $service,
            'others' => Service::published()->ordered()->whereKeyNot($service->id)->take(4)->get(),
            'projects' => Project::published()->ordered()->take(3)->get(),
        ]);
    }
}
