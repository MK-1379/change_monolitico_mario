@extends('layouts.public')

@section('title', 'Entrar · Change.org')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-7 col-lg-5">
                <h1 class="fw-bold mb-4">Inicia sesión</h1>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">Recordarme</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a class="small link-light" href="{{ route('password.request') }}">¿Has olvidado tu contraseña?</a>
                        @endif
                        <button type="submit" class="btn btn-warning fw-bold">Entrar</button>
                    </div>
                </form>

                <p class="mt-4 text-body-secondary">¿No tienes cuenta? <a class="link-light" href="{{ route('register') }}">Regístrate</a></p>
            </div>
        </div>
    </div>
@endsection
