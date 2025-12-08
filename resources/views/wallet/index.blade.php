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
                    <p><strong>Current Balance:</strong> ${{ number_format($user->wallet_balance, 2) }}</p>

                    <form method="POST" action="{{ route('coinpayments.createInvoice') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Crypto</label>
                            <select name="crypto" class="form-select" required>
                                <!--<option value="BTC">Bitcoin (BTC)</option>-->
                                <!--<option value="ETH">Ethereum (ETH)</option>-->
                                <option value="USDTTRC20">USDT (TRC20)</option>
                                <!--<option value="USDTERC20">USDT (ERC20)</option>-->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (USD)</label>
                            <input type="number" name="amount" class="form-control" min="10" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info btn-lg">Top-Up</button>
                        </div>
                    </form>

                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

        </div>
    </div>
</div>
@endsection
