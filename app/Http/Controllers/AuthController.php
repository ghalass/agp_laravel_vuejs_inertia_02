<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    function showLogin()
    {
        $user = User::where('email', '=', 'admin@admin.com')->first();
        // dd(!$user);
        if (!$user) {
            User::create([
                'name'              => 'Admin',
                'email'             => 'admin@admin.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('@dmin12345678'),
            ]);
        }
        return Inertia::render("Login");
    }

    function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $defaultRoute = route('home');
            $intendedRoute = redirect()->intended($defaultRoute)->getTargetUrl();
            return Inertia::location($intendedRoute);
        }

        return back()->withErrors([
            'email' => "Email ou mot de passe incorrect!"
        ])->onlyInput('email');
    }

    function logout()
    {
        Auth::logout();
        return Inertia::location('/login');
    }
}