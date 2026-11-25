@extends('layouts.public')

@section('title', 'Página no encontrada · Change.org')

@section('content')
    <div class="container text-center py-5">
        <p class="display-1 fw-bold text-warning mb-0">404</p>
        <h1 class="fw-bold mb-3">Esta página no existe</h1>
        <p class="lead text-body-secondary mb-4">Puede que el enlace esté mal escrito o que la página se haya eliminado.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-warning btn-lg fw-bold">Ir al inicio</a>
            <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light btn-lg fw-bold">Ver peticiones</a>
        </div>
    </div>
@endsection
