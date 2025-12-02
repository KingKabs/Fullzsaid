@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Your Cart</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
    <p>Your cart is empty.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Person</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>${{ number_format($item['price'], 2) }}</td>
                <td>1</td>
                <td>${{ number_format($item['price'], 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i> Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th colspan="2">${{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="mb-3">
        <p><strong>Your Wallet Balance:</strong> ${{ number_format(auth()->user()->wallet_balance, 2) }}</p>

        @if(auth()->user()->wallet_balance < $total)
        <div class="alert alert-warning">
            Insufficient wallet balance. Please <a href="{{ route('wallet.index') }}">top up</a> to confirm your order.
        </div>
        @endif
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Clear Cart</button>
        </form>

        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success" @if(auth()->user()->wallet_balance < $total) disabled @endif>
                <i class="bi bi-check2-circle"></i> Confirm Order
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
