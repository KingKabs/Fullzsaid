<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller {

    public function index() {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all
            $payments = Payment::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            // Regular user sees only their own payments
            $payments = Payment::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }

        return view('payments.index', compact('payments'));
    }
}
