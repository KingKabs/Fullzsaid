@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Top Up Wallet</h3>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('wallet.charge') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label>Amount (USD)</label>
            <input type="number" name="amount" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Top Up</button>
    </form>
</div>
@endsection
