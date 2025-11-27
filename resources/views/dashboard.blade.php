@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4">
                    Dashboard
                </div>

                <div class="card-body p-4">

                    <h4 class="mb-3">Welcome, {{ Auth::user()->name }}!</h4>
                    <p class="mb-4">Here you can manage your account, view persons, and access other features.</p>

                    <p><strong>Wallet Balance:</strong> ${{ number_format(Auth::user()->wallet_balance, 2) }}</p>
                    <p><strong>Wallet Address:</strong> {{ Auth::user()->wallet_address }}</p>
                    <a href="{{ route('wallet.index') }}" class="btn btn-info">Top-Up Wallet</a>                    

                </div>
            </div>

            <div class="text-center mt-3 text-muted">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </div>

        </div>
    </div>
</div>
@endsection
