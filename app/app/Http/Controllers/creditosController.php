<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\CreditoHistorico;

class creditosController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function getCreditos(Request $request)
    {
        $user = $request->user();

        // Recuperar créditos e histórico do banco de dados
        $currentCredits = $user->credits; // Exemplo: campo na tabela de usuários
        $history = $user->creditHistory()->get(); // Exemplo: relacionamento

        return response()->json([
            'currentCredits' => $currentCredits,
            'history' => $history->map(function ($item) {
                return [
                    'date' => $item->created_at->format('d/m/Y'),
                    'description' => $item->description,
                    'amount' => $item->amount,
                ];
            }),
        ]);
    }

    public function createCheckoutSession(Request $request)
    {
        $user = $request->user();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => 'prod_SCYichnAzgsSLo', // ID do preço do produto na Stripe
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('dashboard.creditos') . '?success=true',
            'cancel_url' => route('dashboard.creditos') . '?canceled=true',
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        return redirect($session->url);
    }

    public function stripeCallback(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;

                $userId = $session->metadata->user_id;

                // Registrar a compra no histórico
                CreditoHistorico::create([
                    'user_id' => $userId,
                    'description' => 'Compra de créditos',
                    'amount' => 10, // Créditos comprados
                    'type' => 'compra',
                ]);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
