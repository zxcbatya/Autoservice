<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        if (Auth::check()) {
            return view('admin.dashboard');
        }

        return view('auth.login');
    }

    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    public function login(Request $request): RedirectResponse
    {
        $adminData = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        if (Auth::attempt(['email' => $adminData['email'], 'password' => $adminData['password']])) {
            $request->session()->regenerate();

            return redirect()->intended('admin/');
        }

        return redirect("/login")->withErrors(["Неправильные данные!!!"]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->logout();

        return redirect('/');
    }
}
