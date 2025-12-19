<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CoinPaymentsController extends Controller {

    public function createPayment(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'crypto' => 'required|string', // e.g., "USDT.TRC20"
        ]);

        $user = Auth::user();
        $orderId = 'wallet_' . $user->id . '_' . time();

        // Build request body according to v2 minimal required fields
        $body = [
            'currency' => 'USD',
            'amount' => $request->amount,
            'description' => 'Wallet Top-up',
            'customData' => [
                'order_id' => $orderId
            ],
            'buyer' => [
                'email' => $user->email
            ],
            'webhooks' => [
                [
                    'url' => route('coinpayments.ipn'),
                    'event' => 'invoice.completed'
                ]
            ],
            'successUrl' => route('wallet.success'),
            'cancelUrl' => route('wallet.cancel')
        ];

        // 🔽 Dump request body
        //dd($body);

        try {
            $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'X-CP-API-Key' => env('COINPAYMENTS_CLIENT_ID'),
                        'X-CP-API-Secret' => env('COINPAYMENTS_CLIENT_SECRET'),
                    ])->post('https://a-api.coinpayments.net/api/v2/merchant/invoices', $body);

            //dd($response);

            if ($response->failed()) {
                return back()->with(
                                'error',
                                "CoinPayments API error ({$response->status()} {$response->reason()})"
                        );
            }



            $data = $response->json();

            if (!isset($data['data']['link'])) {
                return back()->with('error', sprintf(
                                        'CoinPayments API error (%s): %s',
                                        $response->status(),
                                        json_encode($data)
                                ));
            }

            return redirect($data['data']['link']);
        } catch (\Throwable $e) {
            return back()->with(
                            'error',
                            'CoinPayments client exception: ' . $e->getMessage()
                    );
        }
    }
}
