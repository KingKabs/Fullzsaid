@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Card Wrapper -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4">
                    {{ __('Login') }}
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
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

                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                            <a class="btn btn-link text-decoration-none text-center" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Optional footer or branding -->
            <div class="text-center mt-3 text-muted">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}
            </div>

        </div>
    </div>
</div>
@endsection
