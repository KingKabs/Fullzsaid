@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #f5f7fa; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Success
                </div>

                <div class="card-body p-4 text-center">
                    <p>Your wallet has been successfully topped up!</p>
                    <a href="{{ route('wallet.index') }}" class="btn btn-primary mt-3">Back to Wallet</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
