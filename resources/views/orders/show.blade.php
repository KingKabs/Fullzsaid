@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-receipt-cutoff text-primary"></i> Order #{{ $order->id }}
        </h3>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to Orders
        </a>
    </div>

    {{-- Order Summary --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">

            @if(auth()->user()->isAdmin())
            <p class="mb-2">
                <strong><i class="bi bi-person-circle"></i> User:</strong>
                {{ $order->user->name }} ({{ $order->user->email }})
            </p>
            @endif

            <p class="mb-2">
                <strong><i class="bi bi-info-circle"></i> Status:</strong>
                <span class="badge bg-info text-dark px-3 py-2">
                    {{ ucfirst($order->status) }}
                </span>
            </p>

            <p class="mb-0">
                <strong><i class="bi bi-cash-stack"></i> Total Amount:</strong>
                <span class="fs-5 fw-semibold text-success">
                    ${{ number_format($order->total_amount, 2) }}
                </span>
            </p>

        </div>
    </div>

    {{-- Order Items --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="fw-bold mb-0"><i class="bi bi-bag-check"></i> Items</h5>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Person</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <a href="{{ route('persons.show', $item->person->id) }}"
                               class="text-decoration-none fw-semibold">
                                {{ $item->person->firstName }} {{ $item->person->lastName }}
                                <i class="bi bi-box-arrow-up-right small text-muted"></i>
                            </a>
                        </td>

                        <td class="text-end">
                            ${{ number_format($item->price, 2) }}
                        </td>

                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>

                        <td class="text-end fw-bold">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
