@extends('dashboard.auth.master')
@section('title', __('keys.login'))

@section('content')
    <div class="d-flex vh-100 align-items-center justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-10 mx-auto p-4 shadow-lg rounded bg-white">
            <!-- Logo -->
            <div class="text-center mb-4">
                <a href="#">
                    <img src="{{ $logo }}" alt="logo" width="50%">
                </a>
            </div>

            <h2 class="text-center mb-3">{{ __('keys.sign_in') }}</h2>

            <!-- Session Status -->
            <x-auth-session-status class="alert alert-info" :status="session('status')"/>

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-3">
                    <label for="inputEmail" class="form-label">{{ __('keys.email') }}</label>
                    <input type="email" name="email" id="inputEmail" value="{{ old('email') }}"
                           class="form-control form-control-lg" placeholder="{{ __('keys.email') }}" autofocus>
                    @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputPassword" class="form-label">{{ __('keys.password') }}</label>
                    <input type="password" name="password" id="inputPassword"
                           class="form-control form-control-lg" placeholder="{{ __('keys.password') }}">
                    @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check mb-3 d-flex align-items-center gap-2">
                    <input class="form-check-input mb-2 mr-0" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label mb-0" for="rememberMe">{{ __('keys.remember') }}</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">{{ __('keys.login') }}</button>
            </form>
        </div>
    </div>
@endsection
