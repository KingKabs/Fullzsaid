@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crypto Payment</h4>
                </div>

                <div class="card-body">

                    <p class="text-muted mb-3">
                        Complete your wallet top-up by sending the crypto amount below.
                    </p>

                    <div class="mb-3">
                        <label class="fw-bold">Amount (USD):</label>
                        <div class="form-control">{{ $payment['price_amount'] }} USD</div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Pay Currency:</label>
                        <div class="form-control">{{ strtoupper($payment['pay_currency']) }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Amount to Send:</label>
                        <div class="form-control">
                            {{ $payment['pay_amount'] }} {{ strtoupper($payment['pay_currency']) }}
                        </div>
                        <!--small class="text-muted">
                            You must send **exactly** this amount.
                        </small-->
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Send To Address:</label>
                        <div class="form-control" id="paymentAddress">
                            {{ $payment['pay_address'] }}
                        </div>

                        <button class="btn btn-outline-secondary btn-sm mt-2"
                                onclick="copyAddress()">
                            Copy Address
                        </button>
                    </div>

                    <!--div class="text-center my-4">
                        {{-- Optional QR using Google Charts --}}
                        <img src="https://chart.googleapis.com/chart?cht=qr&chs=220x220&chl={{ $payment['pay_address'] }}"
                             alt="QR Code"
                             class="img-fluid rounded shadow">
                        <p class="text-muted mt-2">Scan to pay</p>
                    </div-->

                    <div class="alert alert-info text-center">
                        <strong>Status:</strong>
                        <span id="payment-status">Waiting for payment…</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function copyAddress() {
        let text = document.getElementById("paymentAddress").innerText;
        navigator.clipboard.writeText(text);
        alert("Address copied to clipboard!");
    }
</script>

<script>
    const paymentRecordId = "{{ $payment->id }}";     // DB ID
    const statusLabel = document.getElementById("payment-status");

    function checkStatus() {
        fetch(`/wallet/payment-status/${paymentRecordId}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.status)
                        return;

                    statusLabel.innerHTML = data.status;

                    if (data.status === "finished") {
                        statusLabel.classList.add("text-success");
                        statusLabel.innerHTML = "Payment confirmed!";
                        setTimeout(() => window.location.href = "{{ route('wallet.index') }}", 2000);
                    }

                    if (data.status === "failed" || data.status === "expired") {
                        statusLabel.classList.add("text-danger");
                        statusLabel.innerHTML = "Payment failed or expired.";
                    }
                });
    }

    setInterval(checkStatus, 10000);
    checkStatus();
</script>




@endsection
