<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class CheckPaymentsStatus extends Command {

    protected $signature = 'payments:check-status';
    protected $description = 'Poll NOWPayments API and update pending payment statuses';

    public function handle() {
        $pending = Payment::whereIn('status', [
                    'waiting', 'confirming', 'pending', 'partially_paid'
                ])->get();

        if ($pending->isEmpty()) {
            $this->info('No pending payments.');
            return;
        }

        foreach ($pending as $payment) {

            $this->info("Checking payment: " . $payment->payment_id);

            $response = Http::withHeaders([
                        'x-api-key' => env('NOWPAYMENTS_API_KEY')
                    ])->get("https://api.nowpayments.io/v1/payment/{$payment->payment_id}");

            if (!$response->successful()) {
                $this->error("API Error for {$payment->payment_id}");
                continue;
            }

            $data = $response->json();

            // Update payment row
            $payment->status = $data['payment_status'];
            $payment->actually_paid = $data['actually_paid'] ?? $payment->actually_paid;
            $payment->pay_amount = $data['pay_amount'] ?? $payment->pay_amount;
            $payment->network = $data['network'] ?? $payment->network;
            $payment->save();

            // If finished → credit wallet
            if ($data['payment_status'] === 'finished') {
                $payment->user->increment('wallet_balance', $data['price_amount']);
                $this->info("Wallet credited for user {$payment->user_id}");
            }
        }

        $this->info('Done processing pending payments.');
    }
}
