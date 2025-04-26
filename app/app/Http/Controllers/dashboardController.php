<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function inicio()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('dashboard.cliente');
        }

        abort(403, 'Unauthorized role.');
    }

    public function adminDashboard()
    {
        // Lógica para carregar o dashboard do admin
        return view('pages.admin.dashboard');
    }

    public function clienteDashboard()
    {
        // Lógica para carregar o dashboard do cliente
        return view('pages.cliente.dashboard');
    }

    public function settings()
    {
        // Lógica para carregar a página de configurações
        return view('pages.auth.settings');
    }

    public function geracoes()
    {
        // Simulação de busca das últimas imagens geradas
        $lastGeneratedImages = [
            (object) ['path' => 'generated/image1.png'],
            (object) ['path' => 'generated/image2.png'],
            (object) ['path' => 'generated/image3.png'],
        ];

        return view('pages.cliente.geracoes', compact('lastGeneratedImages'));
    }
}
