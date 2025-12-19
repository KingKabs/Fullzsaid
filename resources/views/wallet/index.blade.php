@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #f5f7fa; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4">
                    Top-Up Wallet
                </div>

                <div class="card-body p-4">

                    {{-- Success message --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Error message --}}
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Validation errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <p class="mb-3">
                        <strong>Current Balance:</strong>
                        ${{ number_format($user->wallet_balance, 2) }}
                    </p>

                    <form method="POST" action="{{ route('wallet.createPayment') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Crypto</label>
                            <select name="crypto" class="form-select" required>
                                <option value="USDTTRC20">USDT (TRC20)</option>
                                <option value="TRX">TRON (TRX)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (USD)</label>
                            <input
                                type="number"
                                name="amount"
                                class="form-control"
                                min="10"
                                required
                                value="{{ old('amount') }}"
                                >
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info btn-lg">
                                Top-Up
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
