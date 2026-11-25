@extends('layouts.public')

@section('title', 'Registrarse · Change.org')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-7 col-lg-5">
                <h1 class="fw-bold mb-4">Crea tu cuenta</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" required autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Repite la contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold w-100">Registrarse</button>
                </form>

                <p class="mt-4 text-body-secondary">¿Ya tienes cuenta? <a class="link-light" href="{{ route('login') }}">Inicia sesión</a></p>
            </div>
        </div>
    </div>
@endsection
