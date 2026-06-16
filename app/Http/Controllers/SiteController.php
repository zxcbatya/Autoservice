<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use App\Models\Page;
use App\Support\SiteImages;

class SiteController extends Controller
{
    public function index(): View
    {
        $viewCount = Setting::firstOrCreate(['key' => 'view_count'], ['value' => '0']);
        $viewCount->value = (int)$viewCount->value + 1;
        $viewCount->save();

        $services = Service::all();
        $reviews = Review::latest()->get();
        $images = SiteImages::all();

        return view('welcome', compact('services', 'reviews', 'images'));
    }

    public function sitemap(): Response
    {
        $pages = Page::all();
        $services = Service::all();

        return response()
            ->view('sitemap', compact('pages', 'services'))
            ->header('Content-Type', 'text/xml');
    }

    public function services()
    {
        //
    }
}
