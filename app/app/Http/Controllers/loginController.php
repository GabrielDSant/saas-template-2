<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function loginPage()
    {
        // Certifique-se de que a rota está correta
        return view('pages.auth.login', [
            'googleLoginUrl' => route('auth.google.redirect'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) { // Uso correto do Auth
            $user = Auth::user(); // Uso correto do Auth

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('cliente')) {
                return redirect()->route('cliente.dashboard');
            }

            Auth::logout(); // Uso correto do Auth
            return redirect()->route('login')->withErrors(['role' => 'Unauthorized role.']);
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials.']);
    }

    public function registerPage()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => 'required|date|before:today',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('cliente');

        auth()->login($user);

        return redirect()->route('cliente.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('dashboard.cliente');
        }

        Auth::logout();
        return redirect()->route('auth.login')->withErrors(['role' => 'Unauthorized role.']);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Uso correto do Auth
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
