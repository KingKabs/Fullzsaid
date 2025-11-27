@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh; background-color: #f5f7fa;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Card Wrapper -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    {{ __('Register') }}
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
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
                            <button type="submit" class="btn btn-success btn-lg">
                                {{ __('Register') }}
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
