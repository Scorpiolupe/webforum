<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // redirect()->intended() kullan, back()->redirect() değil
            return redirect()->intended(route('home')); 
        }

        return back()->withErrors([
            'email' => 'Verilen bilgiler kayıtlarımızla eşleşmiyor.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        Auth::login($user);
        
        // route() helper'ı ile route ismi kullan
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // route() helper'ı ile route ismi kullan
        return redirect()->route('home');
    }
}