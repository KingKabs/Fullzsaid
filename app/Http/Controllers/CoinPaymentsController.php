<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class CoinPaymentsController extends Controller {

    public function createInvoice(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'crypto' => 'required|string'
        ]);

        $user = Auth::user();
        $orderId = 'wallet_' . $user->id . '_' . time();

        try {
            $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'X-CP-API-Key' => env('COINPAYMENTS_CLIENT_ID'),
                        'X-CP-API-Secret' => env('COINPAYMENTS_CLIENT_SECRET'),
                    ])->post('https://a-api.coinpayments.net/api/v2/merchant/invoices', [
                'currency' => $request->crypto,
                'amount' => $request->amount,
                'custom_id' => $orderId,
                'buyer_email' => $user->email,
                'ipn_callback_url' => route('coinpayments.ipn'),
                'description' => 'Wallet Top-up'
            ]);

            $data = $response->json();

            // Debug API response
            dd($response);

            if (!isset($data['data']['id'])) {
                return back()->with('error', $data['error'] ?? 'Unable to create invoice.');
            }

            // Redirect to hosted invoice page
            return redirect($data['data']['url']);
        } catch (\Exception $e) {
            // Catch any network or HTTP errors
            dd('Error:', $e->getMessage());
        }
    }

    public function createPayment(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'crypto' => 'required|string'
        ]);

        $user = Auth::user();
        $orderId = 'wallet_' . $user->id . '_' . time();

        // Save pending payment
        /* $payment = Payment::create([
          'user_id' => $user->id,
          'order_id' => $orderId,
          'currency' => $request->crypto,
          'amount' => $request->amount,
          'status' => 'pending'
          ]); */

        // REST API request
        $response = Http::withBasicAuth(env('COINPAYMENTS_CLIENT_ID'), env('COINPAYMENTS_CLIENT_SECRET'))
                ->post('https://a-api.coinpayments.net/v1/transaction/create', [
                    'amount' => $request->amount,
                    'currency1' => 'USD',
                    'currency2' => $request->crypto,
                    'buyer_email' => $user->email,
                    'custom' => $orderId,
                    'ipn_url' => route('coinpayments.ipn'),
                    'item_name' => 'Wallet Top-up',
        ]);

        $data = $response->json();
        dd($data);

        if (!isset($data['result']['txn_id'])) {
            return back()->with('error', $data['error'] ?? 'Unable to create transaction.');
        }

        // Save transaction ID
        //$payment->update(['txn_id' => $data['result']['txn_id']]);

        return view('wallet.coinpayments-pay', [
            'payment' => $payment,
            'address' => $data['result']['address'],
            'amount' => $data['result']['amount']
        ]);
    }

    public function ipn(Request $request) {
        $raw = file_get_contents('php://input');
        $hmac = hash_hmac('sha512', $raw, env('COINPAYMENTS_IPN_SECRET'));

        if (!hash_equals($hmac, $request->header('HMAC'))) {
            return response('Invalid signature', 403);
        }

        $data = $request->all();

        $payment = Payment::where('order_id', $data['custom'])->first();

        if (!$payment) {
            return response('Not found', 404);
        }

        // status >= 100 means payment complete
        if ($data['status'] >= 100) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now()
            ]);
        } elseif ($data['status'] < 0) {
            $payment->update(['status' => 'failed']);
        }

        return response('OK', 200);
    }
}
