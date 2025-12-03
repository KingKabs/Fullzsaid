@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-credit-card"></i> Payment Transactions
                    </h3>
                </div>

                <div class="box-body table-responsive">

                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Pay Currency</th>
                                <th>Price Amount</th>
                                <th>Pay Amount</th>
                                <th>Pay Address</th>
                                <th>Status</th>
                                <th>Actually Paid</th>
                                <th>Network</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>

                                {{-- USER --}}
                                <td>
                                    @if($payment->user)
                                    <strong>{{ $payment->user->name }}</strong><br>
                                    <small class="text-muted">{{ $payment->user->email }}</small>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <td>{{ $payment->payment_id ?? '-' }}</td>
                                <td>{{ $payment->order_id ?? '-' }}</td>
                                <td>{{ strtoupper($payment->pay_currency) }}</td>

                                <td>{{ number_format($payment->price_amount, 2) }}</td>
                                <td>{{ number_format($payment->pay_amount, 8) }}</td>

                                <td style="">
                                    <code>{{ $payment->pay_address }}</code>
                                </td>

                                <td>
                                    <span class="label
                                          @if($payment->status === 'finished') label-success
                                          @elseif($payment->status === 'confirming') label-info
                                          @elseif($payment->status === 'pending') label-warning
                                          @elseif($payment->status === 'expired') label-default
                                          @else label-danger
                                          @endif
                                          ">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>

                                <td>{{ number_format($payment->actually_paid, 8) ?? '0.0' }}</td>
                                <td>{{ $payment->network ?? '-' }}</td>

                                <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $payment->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-center text-muted p-4">
                                    <i class="fa fa-info-circle"></i> No payment records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
