<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller {
    #NowPaymnts IPN secret key: DHLgS+E1fHUy40iqovLm2PSyKmL3yg2Z

    public function index() {
        $user = Auth::user();
        return view('wallet.index', compact('user'));
    }

    public function topUpForm() {
        $user = auth()->user();
        return view('wallet.topup', compact('user'));
    }

    public function createInvoice(Request $request) {
        $request->validate([
            'crypto' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();

        $response = Http::withHeaders([
                    'x-api-key' => env('NOWPAYMENTS_API_KEY'),
                    'Content-Type' => 'application/json'
                ])->post('https://api.nowpayments.io/v1/invoice', [
            "price_amount" => $request->amount,
            "price_currency" => "USD",
            "pay_currency" => $request->crypto,
            "order_id" => "wallet_{$user->id}_" . time(),
            "order_description" => "Wallet top-up for {$user->name}",
            "ipn_callback_url" => route('wallet.webhook')
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['invoice_url'])) {
            return redirect($data['invoice_url']);
        }

        return back()->with('error', $data['message'] ?? 'Unable to create invoice.');
    }

    public function handleWebhook(Request $request) {
        $payload = $request->all();

        if (!isset($payload['order_id'])) {
            return response()->json(['error' => 'invalid'], 400);
        }

        // Extract user
        preg_match('/wallet_(\d+)_/', $payload['order_id'], $matches);
        if (!isset($matches[1])) {
            return response()->json(['error' => 'invalid user'], 400);
        }

        $user = \App\Models\User::find($matches[1]);
        if (!$user) {
            return response()->json(['error' => 'not found'], 404);
        }

        // Only credit when finished
        if ($payload['payment_status'] === 'finished') {

            $usdAmount = $payload['price_amount']; // always USD

            $user->wallet_balance += $usdAmount;
            $user->save();
        }

        return response()->json(['status' => 'ok']);
    }

    public function testPayment($paymentId) {
        $response = Http::withHeaders([
                    'x-api-key' => env('NOWPAYMENTS_API_KEY'),
                ])->post("https://api.nowpayments.io/v1/payment/$paymentId", [
            'payment_status' => 'finished'
        ]);

        return $response->json();
    }
}
