@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Complete Your Payment</h3>

    <div class="card p-3">
        <p><strong>Amount:</strong> {{ $charge['pricing']['local']['amount'] }} {{ $charge['pricing']['local']['currency'] }}</p>
        <p><strong>Status:</strong> {{ $charge['timeline'][0]['status'] }}</p>

        <p>Scan the QR code to pay:</p>
        <img src="{{ $charge['hosted_url'] }}" alt="Pay via Coinbase" class="img-fluid">
    </div>

    <p class="mt-3">
        <a href="{{ route('wallet.topup') }}" class="btn btn-secondary">Back</a>
    </p>
</div>
@endsection
