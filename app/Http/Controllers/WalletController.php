<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;

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

    public function createPayment(Request $request) {
        $request->validate([
            'crypto' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();

        $orderId = "wallet_{$user->id}_" . time();

        // Step 1: Create payment via NOWPayments API
        $response = Http::withHeaders([
                    'x-api-key' => env('NOWPAYMENTS_API_KEY'),
                    'Content-Type' => 'application/json'
                ])->post('https://api.nowpayments.io/v1/payment', [
            "price_amount" => $request->amount,
            "price_currency" => "USD",
            "pay_currency" => $request->crypto,
            "order_id" => $orderId,
            "order_description" => "Wallet top-up",
        ]);

        $data = $response->json();

        if (!$response->successful() || !isset($data['payment_id'])) {
            return back()->with('error', 'Payment creation failed.');
        }

        // Step 2: Save payment record
        $paymentModel = Payment::create([
            'user_id' => $user->id,
            'payment_id' => $data['payment_id'],
            'order_id' => $orderId,
            'pay_currency' => $request->crypto,
            'price_amount' => $request->amount,
            'pay_amount' => $data['pay_amount'] ?? null,
            'pay_address' => $data['pay_address'] ?? null,
            'status' => $data['payment_status'] ?? 'waiting'
        ]);

        // Step 3: Render the payment screen
        return view('wallet.crypto_payment', [
            'paymentApi' => $data, // array from API
            'payment' => $paymentModel // model with DB ID
        ]);
    }

    public function checkPaymentStatus(Payment $payment) {
        $response = Http::withHeaders([
                    'x-api-key' => env('NOWPAYMENTS_API_KEY'),
                ])->get("https://api.nowpayments.io/v1/payment/{$payment->payment_id}");

        if (!$response->successful()) {
            return response()->json(['status' => 'error']);
        }

        $data = $response->json();

        // Update DB
        $payment->update([
            'status' => $data['payment_status'],
            'actually_paid' => $data['actually_paid'] ?? null,
            'pay_amount' => $data['pay_amount'] ?? $payment->pay_amount,
            'network' => $data['network'] ?? null,
        ]);

        // Auto-credit wallet if finished
        if ($data['payment_status'] === 'finished') {
            $user = $payment->user;
            $user->wallet_balance += $payment->price_amount;
            $user->save();
        }

        return response()->json([
                    'status' => $data['payment_status'],
                    'actually_paid' => $data['actually_paid'],
        ]);
    }

    public function handleWebhook(Request $request) {
        $payload = $request->all();

        // Verify IPN secret (replace 'YOUR_IPN_SECRET' with your actual secret)
        $ipnSecret = $request->header('x-nowpayments-sig') ?? $request->input('ipn_secret');
        if ($ipnSecret !== env('NOWPAYMENTS_IPN_SECRET', 'DHLgS+E1fHUy40iqovLm2PSyKmL3yg2Z')) {
            Log::warning('Invalid NowPayments IPN secret', $payload);
            return response()->json(['error' => 'invalid secret'], 403);
        }

        // Log payload for inspection
        Log::info('NowPayments Webhook:', $payload);

        // Optional: also save to storage file
        $logFile = storage_path('logs/nowpayments_webhook.log');
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . json_encode($payload) . PHP_EOL, FILE_APPEND);

        return response()->json(['status' => 'ok']);
    }

    public function getPaymentStatus($paymentId) {
        dd($paymentId);
        $apiKey = env('NOWPAYMENTS_API_KEY'); // Your NowPayments API key
        $url = "https://api.nowpayments.io/v1/payment/{$paymentId}";

        $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                ])->get($url);

        if ($response->failed()) {
            Log::error('NowPayments API request failed', ['payment_id' => $paymentId, 'response' => $response->body()]);
            return response()->json(['error' => 'API request failed'], 500);
        }

        $data = $response->json();

        // Optional: log response for inspection
        Log::info('NowPayments Payment Status:', $data);

        return response()->json($data);
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
