<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function inicio()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('pages.admin.dashboard');
        } elseif ($user->hasRole('cliente')) {
            return view('pages.cliente.dashboard');
        }

        abort(403, 'Unauthorized role.');
    }

    public function settings()
    {
        // Lógica para carregar a página de configurações
        return view('pages.auth.settings');
    }
}
