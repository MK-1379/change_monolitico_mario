@extends('layouts.public')

@section('title', 'Descubre tu próxima causa · Change.org')

@section('content')
    <div class="container">
        <section class="text-center py-5">
            <h1 class="display-4 fw-bold">Descubre tu próxima causa</h1>
            <p class="lead mb-4">Explora millones de peticiones y encuentra las que te interesan</p>
            <form class="row g-2 justify-content-center" role="search">
                <div class="col-12 col-md-7 col-lg-5">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control" placeholder="Buscar peticiones" aria-label="Buscar peticiones">
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <button class="btn btn-warning btn-lg w-100 fw-bold" type="submit">Buscar</button>
                </div>
            </form>
        </section>

        <section class="mb-5">
            <h2 class="h4 fw-bold mb-3">Explorar</h2>
            <div class="row row-cols-3 g-3">
                <div class="col">
                    <a href="#patrocinadas" class="card h-100 text-center text-decoration-none shadow explorar-card">
                        <div class="card-body px-1">
                            <i class="bi bi-geo-alt fs-2 text-warning"></i>
                            <p class="fw-semibold small mb-0">Cerca de ti</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#patrocinadas" class="card h-100 text-center text-decoration-none shadow explorar-card">
                        <div class="card-body px-1">
                            <i class="bi bi-graph-up-arrow fs-2 text-warning"></i>
                            <p class="fw-semibold small mb-0">Populares</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#patrocinadas" class="card h-100 text-center text-decoration-none shadow explorar-card">
                        <div class="card-body px-1">
                            <i class="bi bi-flag fs-2 text-warning"></i>
                            <p class="fw-semibold small mb-0">Victorias</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h2 class="h4 fw-bold mb-3">Temas</h2>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Política y Gobierno</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Políticas Públicas</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Gobierno Local</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Medioambiente</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Bienestar y Salud</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Educación</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Negocios y Economía</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Justicia Penal</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Gobierno Nacional</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Conservación y Derechos de los Animales</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Bienestar de Familias y Niños</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Entretenimiento y Medios</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Derechos de los Animales</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Bienestar de los Animales</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Justicia Económica</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Salud Pública</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Biodiversidad de la Fauna</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Corrupción</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Deportes</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Discapacidad</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Derechos de los niños</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Gobierno Regional</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Acceso a Atención Médica</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Conservación de la fauna</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Cuestiones Estudiantiles</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Tecnología</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Prevención de delitos</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Derechos de las Mujeres</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Contaminación del agua</a>
                <a class="btn btn-outline-primary text-light" href="#patrocinadas">Deforestación</a>
            </div>
        </section>

        <section id="patrocinadas">
            <h2 class="h4 fw-bold mb-3">Peticiones</h2>

            @if ($peticiones->isEmpty())
                <p class="text-body-secondary">Todavía no hay peticiones.</p>
            @endif

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach ($peticiones as $peticion)
                    <div class="col">
                        <div class="card h-100 shadow-sm peticion-card">
                            {{-- La tabla no tiene imagen: ponemos una de las de public/img según la posición --}}
                            <img src="{{ asset('img/listado-' . str_pad($loop->index % 11 + 1, 2, '0', STR_PAD_LEFT) . '.webp') }}" class="card-img-top" alt="">
                            <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2" aria-label="Ver petición"><i class="bi bi-arrow-right text-black"></i></a>
                            <div class="card-body d-flex flex-column">
                                <span class="small text-body-secondary">{{ $peticion->categoria?->nombre }}</span>
                                <h3 class="card-title h6 fw-bold mt-1">{{ $peticion->titulo }}</h3>
                                <p class="small text-body-secondary">Para: {{ $peticion->destinatario }}</p>
                                <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> {{ $peticion->firmantes }} firmas</p>
                                <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn btn-outline-light">Ver petición</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    
    </div>
@endsection
