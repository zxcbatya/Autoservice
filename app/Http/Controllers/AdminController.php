<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function dashboard(): View
    {
        $stats = [
            'users' => User::count(),
            'services' => Service::count(),
            'reviews' => Review::count(),
            'views' => Setting::where('key', 'view_count')->value('value') ?? 0,
        ];

        $siteHealth = [
            'services_no_description' => Service::whereNull('description')->count(),
            'pages_no_content' => Page::whereNull('text')->count(),
            'robots_exists' => File::exists(public_path('robots.txt')),
        ];

        $latestReviews = Review::latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestReviews' => $latestReviews,
            'siteHealth' => $siteHealth,
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $adminData = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        if (Auth::attempt(
            ['email' => $adminData['email'], 'password' => $adminData['password']],
            $request->boolean('remember'),
        )) {
            $user = Auth::user();
            if (! $user->is_admin && ! $user->hasAnyRole(['admin', 'manager'])) {
                Auth::logout();

                return redirect('/login')->withErrors(['email' => 'Нет доступа в админ-панель.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect('/login')->withErrors(['email' => 'Неправильный email или пароль.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->logout();

        return redirect('/');
    }
}
