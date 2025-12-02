@extends('layouts.app')

@section('content')
<div class="container">
    <h3>My Orders</h3>

    @if($orders->isEmpty())
    <p>You have no orders yet.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                @if(auth()->user()->isAdmin())
                <th>User</th>
                @endif
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                @if(auth()->user()->isAdmin())
                <td>{{ $order->user->name }} ({{ $order->user->email }})</td>
                @endif
                <td>${{ number_format($order->total_amount, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    {{ $orders->links() }}
    @endif
</div>
@endsection
