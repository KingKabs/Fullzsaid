@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-bag-check text-primary"></i> My Orders
        </h3>
    </div>

    @if($orders->isEmpty())

    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle me-2 fs-5"></i>
        You have no orders yet.
    </div>

    @else

    {{-- Orders Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>

                        @if(auth()->user()->isAdmin())
                        <th>User</th>
                        @endif

                        <th class="text-end">Total Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="fw-semibold">#{{ $order->id }}</td>

                        @if(auth()->user()->isAdmin())
                        <td>
                            <i class="bi bi-person-circle text-secondary"></i>
                            {{ $order->user->name }}
                            <span class="text-muted small">({{ $order->user->email }})</span>
                        </td>
                        @endif

                        <td class="text-end">
                            <span class="fw-semibold text-success">
                                ${{ number_format($order->total_amount, 2) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-info text-dark px-3 py-2">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>

                        <td class="text-end">
                            <a href="{{ route('orders.show', $order) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $orders->links() }}
    </div>

    @endif
</div>
@endsection
