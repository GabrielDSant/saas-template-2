<?php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)), // Senha aleatória
            ]
        );

        Auth::login($user);

        // Redireciona para o dashboard correto com base na role
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('dashboard.cliente');
        }

        Auth::logout();
        return redirect()->route('auth.login')->withErrors(['role' => 'Unauthorized role.']);
    }
}