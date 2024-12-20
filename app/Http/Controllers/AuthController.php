<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    function showLogin()
    {
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