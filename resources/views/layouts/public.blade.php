@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!doctype html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'El cambio comienza aquí · Change.org')</title>
    <link rel="icon" href="{{ asset('img/favicon.svg') }}?v=2" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand logo fs-3 me-lg-5" href="{{ route('home') }}">change.org</a>
            <a class="btn btn-outline-light btn-sm ms-auto me-2 d-lg-none" href="{{ route('peticiones.create') }}">Inicia una petición</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto gap-4">
                    @if (Auth::check())
                        <li class="nav-item fw-bold"><a class="nav-link" href="{{ route('peticiones.mine') }}">Mis peticiones</a></li>
                        <li class="nav-item fw-bold"><a class="nav-link" href="{{ route('peticiones.peticionesfirmadas') }}">Mis firmas</a></li>
                    @endif
                    <li class="nav-item fw-bold"><a class="nav-link" href="#">Programa de socios/as</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="{{ route('peticiones.index') }}"><i class="bi bi-search"></i> Buscar</a></li>
                </ul>
                <ul class="navbar-nav align-items-lg-center fw-bold">
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="btn btn-outline-light" href="{{ route('peticiones.create') }}">Inicia una petición</a>
                    </li>
                    @if (!Auth::check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                    @endif
                    @if (Auth::check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-person-circle"></i> {{ Auth::user()->name }}</a></li>
                        <li class="nav-item ms-lg-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if (session('error') || session('success'))
            <div class="container mt-3">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-top mt-5 py-5">
        <div class="container">
            <div class="row row-cols-2 row-cols-md-5 g-4">
                <div class="col">
                    <h2 class="h6 fw-bold">Participa</h2>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item"><a href="{{ route('peticiones.create') }}" class="nav-link p-0 text-body-secondary">Inicia una petición</a></li>
                        <li class="nav-item"><a href="{{ route('peticiones.index') }}" class="nav-link p-0 text-body-secondary">Busca por tema</a></li>
                        <li class="nav-item"><a href="{{ route('peticiones.index') }}" class="nav-link p-0 text-body-secondary">Busca peticiones</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h2 class="h6 fw-bold">Aprende</h2>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Guías para peticiones</a></li>
                        <li class="nav-item"><a href="{{ route('peticiones.create') }}" class="nav-link p-0 text-body-secondary">Crea tu petición</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Reúne firmas</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Contacta a los medios</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Involucra al destinatario de la petición</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h2 class="h6 fw-bold">Sobre nosotros</h2>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Sobre Change.org</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Visión</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Equipo</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Empleo</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Prensa</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h2 class="h6 fw-bold">Ayuda y aspectos legales</h2>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Centro de ayuda</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Normas de la comunidad</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Política de privacidad</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Términos de uso</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Política de cookies</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Administra cookies</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h2 class="h6 fw-bold">Síguenos</h2>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Instagram</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">X</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">Facebook</a></li>
                        <li class="nav-item"><a href="#" class="nav-link p-0 text-body-secondary">TikTok</a></li>
                    </ul>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-top pt-4 mt-5">
                <div>
                    <p class="small text-body-secondary mb-2 fw-bold">© {{ date('Y') }} Réplica de Change.org</p>
                    <p class="small text-body-secondary">Esta web está protegida por reCAPTCHA y por Google <a href="https://policies.google.com/privacy">Política de privacidad</a> y <a href="https://policies.google.com/terms">Normas de uso</a>.</p>
                </div>

                <select class="form-select form-select-sm w-auto p-3 border-light rounded-3" aria-label="Idioma">
                    <option selected>Español (España)</option>
                    <option>Español (Argentina)</option>
                    <option>English (United States)</option>
                </select>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
