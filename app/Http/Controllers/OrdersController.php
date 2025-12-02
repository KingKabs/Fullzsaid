<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller {

    // List orders
    public function index() {
        if (Auth::user()->isAdmin()) {
            // Admin sees all orders
            $orders = Order::with('user', 'items.person')->latest()->paginate(20);
        } else {
            // Normal user sees only their orders
            $orders = Order::with('items.person')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(20);
        }

        return view('orders.index', compact('orders'));
    }

    // Show single order
    public function show(Order $order) {
        $order->load('user', 'items.person');
        return view('orders.show', compact('order'));
    }
}
