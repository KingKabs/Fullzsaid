@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Complete Your Payment</h4>

    <div class="card p-3">
        <p><strong>Send exactly:</strong> {{ $amount }} {{ $payment->currency }}</p>
        <p><strong>To address:</strong></p>
        <code>{{ $address }}</code>

        <p class="mt-2 text-muted">
            Waiting for blockchain confirmation…
        </p>
    </div>
</div>
@endsection
