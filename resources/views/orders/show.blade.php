@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Order #{{ $order->id }}</h3>
    @if(auth()->user()->isAdmin())
    <p><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
    @endif
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>

    <h5>Items</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Person</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->person->firstName }} {{ $item->person->lastName }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection
