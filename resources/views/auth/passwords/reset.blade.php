@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Card Wrapper -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark text-center fw-bold fs-4">
                    {{ __('Reset Password') }}
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}" required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-warning btn-lg">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Optional footer -->
            <div class="text-center mt-3 text-muted">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}
            </div>

        </div>
    </div>
</div>
@endsection
