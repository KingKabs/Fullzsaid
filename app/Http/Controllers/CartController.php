<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller {

    // Show cart page
    public function index() {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    // Add item to cart
    public function add($id) {
        $person = Person::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $person->id,
                'name' => $person->firstName . ' ' . $person->lastName,
                'price' => $person->price ?? 10, // fallback price
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart.');
    }

    // Remove single item
    public function remove($id) {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    // Clear entire cart
    public function clear() {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    // Update quantity
    public function update(Request $request, $id) {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function checkout(Request $request) {
        $user = auth()->user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Check wallet balance
        if ($user->wallet_balance < $total) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        \DB::transaction(function () use ($user, $cart, $total) {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'paid' // since we deduct wallet instantly
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'person_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Optional: mark person as purchased
                $person = Person::find($item['id']);
                $person->is_sold = true; // add this column to persons table
                $person->save();
            }

            // Deduct wallet balance
            $user->wallet_balance -= $total;
            $user->save();

            // Clear cart
            session()->forget('cart');
        });

        return redirect()->route('cart.index')->with('success', 'Order completed successfully!');
    }
}
