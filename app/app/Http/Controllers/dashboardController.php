<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Estilos;
use App\Models\GeneratedImage;

class dashboardController extends Controller
{
    public function inicio()
    {
        $user = Auth::user();

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
        $user = Auth::user();
        $currentCredits = $user->credits()->sum('amount');
        $history = $user->creditHistory()->latest()->take(10)->get();
        $generatedImages = GeneratedImage::where('user_id', $user->id)->latest()->take(6)->get();
        return view('pages.cliente.dashboard', compact('user', 'currentCredits', 'history', 'generatedImages'));
    }


    public function geracoes()
    {
        $user = Auth::user();
        $generatedImages = GeneratedImage::where('user_id', $user->id)->latest()->get();
        $estilos = Estilos::all();
        return view('pages.cliente.geracoes', compact('generatedImages', 'estilos'));
    }

    public function adminUsuarios()
    {
        // Lógica para carregar a página de usuários do admin
        return view('pages.admin.usuarios');
    }

    public function creditos()
    {
        // Lógica para carregar a página de usuários do admin
        return view('pages.cliente.creditos');
    }
    public function adminEstatisticas()
    {
        // Lógica para carregar a página de estatísticas do admin
        return view('pages.admin.estatisticas');
    }
}
