@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Login</h1>
    
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info text-center mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="card shadow-lg border-0 rounded-3 p-4 mx-auto" style="max-width: 500px;">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                   class="form-control @error('email') is-invalid @enderror" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">Remember Me</label>
        </div>

        <!-- Forgot Password and Login Button -->
        <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary px-4 py-2">
                Log In
            </button>
        </div>
    </form>
</div>
@endsection
