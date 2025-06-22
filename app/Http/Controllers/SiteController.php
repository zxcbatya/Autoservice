<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;

class SiteController extends Controller
{
    public function index(): View
    {
        $services = \App\Models\Service::all();
        $reviews = \App\Models\Review::orderByDesc('created_at')->take(9)->get();
        return view('welcome', compact('services', 'reviews'));
    }
}
