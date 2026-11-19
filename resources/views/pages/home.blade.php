@extends('layouts.public')

@section('title', 'El cambio comienza aquí · Change.org')

@section('content')
    <section class="container text-center py-5">
        <h1 class="display-3 fw-bold">El cambio<br>comienza aquí<span class="logo">.</span></h1>
        <p>Te ayudaremos a lograr el cambio que quieres ver.</p>
        <p class="fw-semibold mt-4">Iniciar una petición para…</p>
        <form action="{{ route('peticiones.create') }}" class="position-relative mx-auto col-lg-6">
            <label for="idea" class="visually-hidden">Describe tu petición</label>
            <textarea id="idea" class="form-control p-3" rows="4"
                placeholder="Es muy difícil moverse en silla de ruedas por mi barrio"></textarea>
            <button type="submit" class="btn btn-warning rounded-circle position-absolute bottom-0 end-0 m-2"
                aria-label="Continuar"><i class="bi bi-arrow-right"></i></button>
        </form>
        <a href="{{ route('peticiones.create') }}" class="d-inline-block mt-3 link-light">Ya tengo el borrador de mi petición <i class="bi bi-arrow-right"></i></a>
    </section>


    <section class="container py-5 text-center">
        <h2 class="h5 fw-bold mb-4">Conoce a personas reales que están transformando sus comunidades.</h2>
        <div id="carruselHistorias" class="carousel slide d-lg-none">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/landing-01.webp') }}" class="rounded-circle historia-img" alt="Señoras con un cartel">
                    <p class="mt-3 mb-1"><span class="badge rounded-pill text-bg-primary fs-6">Trending!</span></p>
                    <p class="mb-1">204.523 firmas</p>
                    <p class="fw-semibold px-5">"Más pediatras en los centros de salud rurales"</p>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/landing-02.webp') }}" class="rounded-circle historia-img" alt="Señora con un cartel">
                    <p class="mt-3 mb-1"><span class="badge rounded-pill text-bg-primary fs-6">Victory!</span></p>
                    <p class="mb-1">157.903 firmas</p>
                    <p class="fw-semibold px-5">Consiguen que la biblioteca abra en época de exámenes</p>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/landing-03.webp') }}" class="rounded-circle historia-img" alt="Ancianos con cartel">
                    <p class="mt-3 mb-1"><span class="badge rounded-pill text-bg-primary fs-6">Victory!</span></p>
                    <p class="mb-1">96.222 firmas</p>
                    <p class="fw-semibold px-5">Conseguido: el parque del río no será un aparcamiento</p>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/landing-04.webp') }}" class="rounded-circle historia-img" alt="Trabajadora con cartel">
                    <p class="mt-3 mb-1"><span class="badge rounded-pill text-bg-primary fs-6">Trending!</span></p>
                    <p class="mb-1">67.341 firmas</p>
                    <p class="fw-semibold px-5">"Sombra y agua en las paradas de autobús en verano"</p>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/landing-05.webp') }}" class="rounded-circle historia-img" alt="Madre e hijo">
                    <p class="mt-3 mb-1"><span class="badge rounded-pill text-bg-primary fs-6">Trending!</span></p>
                    <p class="mb-1">100.887 firmas</p>
                    <p class="fw-semibold px-5">"Carril bici seguro hasta los institutos"</p>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carruselHistorias" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carruselHistorias" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <div class="row row-cols-5 d-none d-lg-flex">
            <div class="col">
                <a href="{{ route('peticiones.index') }}" class="text-decoration-none text-reset peticiones-landing">
                    <img src="{{ asset('img/landing-01.webp') }}" class="rounded-circle historia-img" alt="Señoras con un cartel">
                    <p class="mt-2 mb-0"><span class="badge rounded-pill text-bg-secondary fs-6">Trending!</span></p>
                    <p class="small">204.523 firmas</p>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('peticiones.index') }}" class="text-decoration-none text-reset peticiones-landing">
                    <img src="{{ asset('img/landing-02.webp') }}" class="rounded-circle historia-img" alt="Señora con un cartel">
                    <p class="mt-2 mb-0"><span class="badge rounded-pill text-bg-secondary fs-6">Victory!</span></p>
                    <p class="small">157.903 firmas</p>
                </a>
            </div>
            
            <div class="col">
                <a href="{{ route('peticiones.index') }}" class="text-decoration-none text-reset peticiones-landing">
                    <img src="{{ asset('img/landing-03.webp') }}" class="rounded-circle historia-img" alt="Ancianos con cartel">
                    <p class="mt-2 mb-0"><span class="badge rounded-pill text-bg-secondary fs-6">Victory!</span></p>
                    <p class="small">96.222 firmas</p>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('peticiones.index') }}" class="text-decoration-none text-reset peticiones-landing">
                    <img src="{{ asset('img/landing-04.webp') }}" class="rounded-circle historia-img" alt="Trabajadora con un cartel">
                    <p class="mt-2 mb-0"><span class="badge rounded-pill text-bg-secondary fs-6">Trending!</span></p>
                    <p class="small">67.341 firmas</p>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('peticiones.index') }}" class="text-decoration-none text-reset peticiones-landing">
                    <img src="{{ asset('img/landing-05.webp') }}" class="rounded-circle historia-img" alt="Madre e hijo">
                    <p class="mt-2 mb-0"><span class="badge rounded-pill text-bg-secondary fs-6">Trending!</span></p>
                    <p class="small">100.887 firmas</p>
                </a>
            </div>
        </div>
    </section>

    <section class="container py-5 text-center">
        <h2 class="fw-bold mb-5">Usar la plataforma de peticiones n.º 1 es fácil</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <span class="paso d-inline-flex align-items-center justify-content-center rounded-circle bg-primary fw-bold mb-3">1</span>
                <h3 class="h6 fw-bold">Crea una petición en dos minutos</h3>
                <p class="small text-body-secondary">Más de 2.000 nuevas cada día</p>
            </div>
            <div class="col">
                <span class="paso d-inline-flex align-items-center justify-content-center rounded-circle bg-primary fw-bold mb-3">2</span>
                <h3 class="h6 fw-bold">Consigue apoyo gracias a nuestra gran comunidad</h3>
                <p class="small text-body-secondary">Más de 500.000 firmas diarias</p>
            </div>
            <div class="col">
                <span class="paso d-inline-flex align-items-center justify-content-center rounded-circle bg-primary fw-bold mb-3">3</span>
                <h3 class="h6 fw-bold">Llega hasta los responsables gracias a nuestra red</h3>
                <p class="small text-body-secondary">Más de 1.000 notificados a diario</p>
            </div>
        </div>

        <div class="accordion mt-4 mx-auto col-lg-6 text-start" id="guias">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#guiasLista" aria-expanded="false" aria-controls="guiasLista">
                        Lee nuestros consejos y guías sobre cómo crear una petición
                    </button>
                </h2>
                <div id="guiasLista" class="accordion-collapse collapse" data-bs-parent="#guias">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('peticiones.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between enlace-flecha">Crea tu petición <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between enlace-flecha">Reúne firmas <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between enlace-flecha">Contacta a los medios <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between enlace-flecha">Involucra al destinatario de la petición <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h2 class="display-6 fw-bold mb-3">Apoya causas que te importan</h2>
                <p class="mb-3">Encuentra peticiones que afecten a tu comunidad.</p>
            </div>
            <a class="btn btn-outline-light btn-lg p-3 fw-bold" href="{{ route('peticiones.index') }}">Ver todos los temas</a>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <a class="btn btn-outline-light btn-lg fw-bold" href="{{ route('peticiones.index') }}">Sanidad <i class="bi bi-arrow-right"></i></a>
            <a class="btn btn-outline-light btn-lg fw-bold" href="{{ route('peticiones.index') }}">Animales <i class="bi bi-arrow-right"></i></a>
            <a class="btn btn-outline-light btn-lg fw-bold" href="{{ route('peticiones.index') }}">Medio Ambiente <i class="bi bi-arrow-right"></i></a>
            <a class="btn btn-outline-light btn-lg fw-bold" href="{{ route('peticiones.index') }}">Educación <i class="bi bi-arrow-right"></i></a>
            <a class="btn btn-outline-light btn-lg fw-bold" href="{{ route('peticiones.index') }}">Justicia Económica <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col">
                <div class="card h-100 peticion-card">
                    <img src="{{ asset('img/landing-06.webp') }}" class="card-img-top" alt="Tren descarrilado">
                    <div class="card-body">
                        <span class="barra-roja d-block mb-2"></span>
                        <h3 class="card-title h5 fw-bold"><a href="{{ route('peticiones.index') }}" class="stretched-link link-light text-decoration-none">Adamuz y Urda, nunca más: compromiso de todos los gobiernos con la seguridad ferroviaria</a></h3>
                        <p class="card-text small text-body-secondary"><i class="bi bi-vector-pen"></i> 55.962 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 peticion-card">
                    <img src="{{ asset('img/landing-07.webp') }}" class="card-img-top" alt="HRT">
                    <div class="card-body">
                        <span class="barra-roja d-block mb-2"></span>
                        <h3 class="card-title h5 fw-bold"><a href="{{ route('peticiones.index') }}" class="stretched-link link-light text-decoration-none">Garantizar acceso a terapia hormonal para menopausia con pauta médica</a></h3>
                        <p class="card-text small text-body-secondary"><i class="bi bi-vector-pen"></i> 33.854 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 peticion-card">
                    <img src="{{ asset('img/landing-08.webp') }}" class="card-img-top" alt="Anciana en un hospitales">
                    <div class="card-body">
                        <span class="barra-roja d-block mb-2"></span>
                        <h3 class="card-title h5 fw-bold"><a href="{{ route('peticiones.index') }}" class="stretched-link link-light text-decoration-none">Tengo 94 años y llevo 3 meses ingresada. Pongan TV gratis en todos los hospitales</a></h3>
                        <p class="card-text small text-body-secondary"><i class="bi bi-vector-pen"></i> 66.138 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 peticion-card">
                    <img src="{{ asset('img/landing-09.webp') }}" class="card-img-top" alt="Chico con lazo negro">
                    <div class="card-body">
                        <span class="barra-roja d-block mb-2"></span>
                        <h3 class="card-title h5 fw-bold"><a href="{{ route('peticiones.index') }}" class="stretched-link link-light text-decoration-none">El asesino de mi hijo tenía 17 años. Pido revisar YA la ley del menor para casos graves</a></h3>
                        <p class="card-text small text-body-secondary"><i class="bi bi-vector-pen"></i> 100.853 firmas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="bg-body-tertiary rounded-3 p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-md-6 order-2 order-md-1">
                    <h2 class="display-6 fw-bold mb-3">Impulsado por personas, no beneficios</h2>
                    <p class="mb-4">Independiente y propiedad de una organización sin ánimo de lucro. Financiada íntegramente por
                        sus miembros: sin anuncios, accionistas ni intereses particulares.</p>
                    <a href="#" class="btn btn-outline-light btn-lg p-3 px-4 fw-bold">Contribuir</a>
                </div>
                <div class="col-md-6 order-1 order-md-2 text-center">
                    <img src="{{ asset('img/landing-10.webp') }}" class="img-fluid" width="300" alt="Tres personas con una bandera">
                </div>
            </div>
        </div>
    </section>

@endsection
