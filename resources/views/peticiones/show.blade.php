@extends('layouts.public')

@section('title', $peticion->titulo . ' · Change.org')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 text-white">
                    @if ($peticion->files->isNotEmpty())
                        <img src="{{ asset($peticion->files->first()->file_path) }}"
                            class="card-img foto-peticion" alt="{{ $peticion->titulo }}">
                    @else
                        <img src="{{ asset('img/detalle-01.webp') }}"
                            class="card-img foto-peticion" alt="Señora de espaldas">
                    @endif
                    <div class="card-img-overlay d-flex flex-column justify-content-end p-4 degradado">
                        <span class="barra-roja d-block mb-3"></span>
                        <h1 class="fw-bold mb-0">{{ $peticion->titulo }}</h1>
                        <p class="mb-0 mt-2">Para: {{ $peticion->destinatario }}</p>
                    </div>
                </div>
                <a href="#firmar" class="btn btn-warning btn-lg w-100 my-3 d-lg-none"><i class="bi bi-vector-pen"></i>
                    Firma la petición</a>
                <div class="card my-4">
                    <div class="card-body">
                        <div class="row align-items-center g-3">
                            <div class="card col-12 col-md-6 p-4 me-5">
                                <span class="badge rounded-5 text-bg-secondary align-self-start text-black">Progreso de
                                    la petición</span>
                                <p class="fw-semibold mb-0 mt-4"><i class="bi bi-graph-up-arrow"></i> Ganando impulso en {{ $peticion->categoria?->nombre }}</p>
                            </div>
                            <div class="col-4 col-md-2">
                                <p class="text-body-secondary mb-0">Compartidos</p>
                                <p class="fs-4 fw-bold mb-0">326</p>
                            </div>
                            <div class="col-4 col-md-2">
                                <p class="text-body-secondary mb-0">Comentarios</p>
                                <p class="fs-4 fw-bold mb-0">17</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="display-6 fw-bold mb-4">El problema</h2>
                <p>{!! nl2br(e($peticion->descripcion)) !!}</p>

                <div>
                    <i class="bi bi-flag"></i> <a href="#">Denunciar una violacion de las políticas</a>
                </div>

                <div
                    class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between border-top border-bottom py-3 my-4">
                    <div class="d-flex align-items-center gap-3">
                        <span
                            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary avatar">
                            <i class="bi bi-person-fill fs-3"></i>
                        </span>
                        <div>
                            <strong>{{ $peticion->user?->name }}</strong><br>
                            <span class="small text-body-secondary">Creador de la petición</span>
                        </div>
                    </div>
                    <div class="mt-3 mt-lg-0">
                        <a href="#" class="btn btn-outline-light fw-bold">Consultas de medios de comunicación</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" id="firmar">
                <div class="card shadow sticky-lg-top">
                    <div class="card-body p-4">
                        <p class="text-center mb-0"><span class="display-6 fw-bold">{{ $peticion->firmantes }}</span> <i
                                class="bi bi-patch-check-fill text-primary"></i></p>
                        <p class="text-center mb-0 mt-2">
                            <a class="link-light text-decoration-none flecha-firmas" data-bs-toggle="collapse"
                                href="#infoFirmas">
                                Firmas verificadas <i class="bi bi-chevron-down"></i>
                            </a>
                        </p>
                        <p class="collapse text-center fst-italic small" id="infoFirmas">
                            Change.org ayuda a verificar que las firmas son de personas reales.
                        </p>
                        <hr>
                        <h2 class="h4 fw-bold">Firma esta petición</h2>
                        <form action="{{ route('peticiones.firmar', $peticion->id) }}" method="POST">
                            @csrf
                            @auth
                                <p class="small">Vas a firmar como <strong>{{ Auth::user()->name }}</strong>.</p>
                            @else
                                <p class="small">Para firmar tienes que <a href="{{ route('login') }}">iniciar sesión</a>.</p>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" required>
                                    <div class="invalid-feedback">Escribe tu nombre.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" required>
                                    <div class="invalid-feedback">Escribe tus apellidos.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" required>
                                    <div class="invalid-feedback">Introduce un correo válido.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacion" value="Logroño, 26007 España">
                                </div>
                            @endauth
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="avisos" id="avisosSi" required>
                                <label class="form-check-label small" for="avisosSi">Quiero saber si esta petición gana
                                    y cómo puedo ayudar a otras peticiones</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="avisos" id="avisosNo" required>
                                <label class="form-check-label small" for="avisosNo">No quiero saber cómo avanza esta
                                    petición</label>
                                <div class="invalid-feedback">Elige una opción.</div>
                            </div>
                            <button type="submit" class="btn btn-warning btn-lg w-100"><i class="bi bi-vector-pen"></i>
                                Firma la petición</button>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="ocultarNombre">
                                <label class="form-check-label small" for="ocultarNombre">No mostrar mi nombre en esta
                                    petición</label>
                            </div>
                            <div class="mt-3">
                                <p class="small">Procesamos tus datos personales de acuerdo con nuestra <a
                                        href="https://policies.google.com/privacy">Política de privacidad</a> y los <a
                                        href="https://policies.google.com/terms">Términos de uso</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="h3 fw-bold mt-5 mb-5">Opiniones de firmantes</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <div class="col">
                        <div class="card text-bg-primary h-100">
                            <div class="card-body">
                                <i class="bi bi-quote fs-2"></i>
                                <p class="fst-italic">Yo sufrí violencia por mi pareja varios años hasta un día que los
                                    vecinos llamaron a la policía vino GC Y LOCAL entraron en la casa y yo estaba fuera
                                    porque...</p>
                                <a href="#" class="text-light">Ver el texto completo</a>
                                <p class="small text-end mb-5 mt-2"><strong>Victoria,</strong> Las Palmas de Gran
                                    Canaria</p>
                                <span class="small ms-2 fw-bold"><i class="bi bi-heart"></i> 9</span><i
                                    class="ms-4 bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-primary h-100">
                            <div class="card-body">
                                <i class="bi bi-quote fs-2"></i>
                                <p class="fst-italic">Yo sufro de violencia intrafamiliar y he buscado ayuda en el
                                    ayuntamiento y me han revictimizado, y la situación empeora cuando ven que soy
                                    negra,...</p>
                                <a href="#" class="text-light">Ver el texto completo</a>
                                <p class="small text-end mb-5 mt-2"><strong>Ysabel,</strong> Sevilla</p>
                                <span class="small ms-2 fw-bold"><i class="bi bi-heart"></i> 1</span><i
                                    class="ms-4 bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-primary h-100">
                            <div class="card-body">
                                <i class="bi bi-quote fs-2"></i>
                                <p class="fst-italic">El gobierno tiene que hacer algo YA. No puede seguir existiendo
                                    esto, es muy triste leer comentarios de mujeres que han sufrido esto. Yo soy hija de
                                    una...</p>
                                <a href="#" class="text-light">Ver el texto completo</a>
                                <p class="small text-end mb-5 mt-2"><strong>Marta,</strong> Santander</p>
                                <span class="small ms-2 fw-bold"><i class="bi bi-heart"></i> </span><i
                                    class="ms-4 bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-primary h-100">
                            <div class="card-body">
                                <i class="bi bi-quote fs-2"></i>
                                <p class="fst-italic">Me ha ATERRADO leer este testimonio…
                                    Y luego dicen que las mujeres “nos lo inventamos” y que “queremos beneficios”...</p>
                                <a href="#" class="text-light">Ver el texto completo</a>
                                <p class="small text-end mb-5 mt-2"><strong>Cristina,</strong> Madrid</p>
                                <span class="small ms-2 fw-bold"><i class="bi bi-heart"></i> 6</span><i
                                    class="ms-4 bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-primary h-100">
                            <div class="card-body">
                                <i class="bi bi-quote fs-2"></i>
                                <p class="fst-italic">Yo también soy mujer de violencia de género.</p>
                                <p class="small text-end mb-5 mt-2"><strong>Maria nieves,</strong> Cruz grande 16 la
                                    rosa</p>
                                <span class="small ms-2 fw-bold"><i class="bi bi-heart"></i> 2</span><i
                                    class="ms-4 bi bi-three-dots"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 bg-transparent">
                            <div
                                class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                                <img src="{{ asset('img/detalle-02.webp') }}"
                                    width="110" alt="" class="mb-4">
                                <p>¡Firma la causa y comparte por qué te importa!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3 mb-5">
                    <a href="#" class="btn btn-outline-light p-3 fw-bold">Consulta la opinión de todos los firmantes</a>
                </div>
                <hr>
                <h2 class="h3 fw-bold mt-4 mb-5">Actualizaciones de la petición</h2>
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-vector-pen fs-4"></i>
                        <div><strong>{{ $peticion->firmantes }} firmantes</strong><br><small class="text-body-secondary">hace 2
                                días</small></div>
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <i class="bi bi-vector-pen fs-4"></i>
                        <div><strong>{{ $peticion->user?->name }} ha lanzado esta petición</strong><br><small
                                class="text-body-secondary">hace 1 mes</small></div>
                    </li>
                </ul>
                <h2 class="h3 fw-bold mt-5 mb-3">Compartir esta petición</h2>

                <div class="row g-4 align-items-start">
                    <div class="col-12 col-lg-4">
                        <div class="card bg-transparent">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAMAAAC5zwKfAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAD5UExURQAAAP////W2vKkUIN4aK+AaK90aKrUVI+hTX+AZKuAYKeAcLeEiMuhWY+6Ci+x0fuZFUuEfL+ImNvCMlf3v8P/9/f75+vzr7e+EjeEfMOAWKOdQXfzq6/309fOmrPfDx/rZ3OU9S98VJutoc/jMz+MzQuZFU/OmrfKjquU/TeAXKetqdfSvteAXKN8UJvW2u+AdLudPXOIoN98WJ+lbZ/729vvh5OhXY+15g/nQ0+ZHVOhTYOEeL+Q0Q/fCxv3y8/739/W1uvvf4vvh4+MuPeZHVfSutPrd4PjP0vGaoeQ4RuIlNfW0uuEjM+MtPOIqOuEgMOAdLeZGVHwBRAUAAAABYktHRAH/Ai3eAAAAB3RJTUUH6gsREB0u2+JRDAAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyNi0xMS0xN1QxNjoyOTo0NiswMDowMMi+IzoAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjYtMTEtMTdUMTY6Mjk6NDYrMDA6MDC545uGAAAAKHRFWHRkYXRlOnRpbWVzdGFtcAAyMDI2LTExLTE3VDE2OjI5OjQ2KzAwOjAw7va6WQAAAg5JREFUWMPdlndbwjAQxhuwQIs46lZcuLe4xb0XDvj+H0ZbSsmN0PiA2HJ/tEl6+aW5ey+tYVATQtSu3j0Ya4wGZuhZ9IDYSYDZ0Au6KxaIBRCEL+jjGBKjczsGZPzIMl0GJE5M4mMO5MUqlbXkiB10KyVKQGwSJbSpZa0BVUWqmAqzzM2MGxAk04B4VcKRxuMDNDSiBIHY1x+NPpAXSL0nLcOtyJTIXwNxPjlhM6cNSm5ngYlkjxlYKp3QAfLx8AOXNoFl0DwJCLeiBKY8jmXbltfItgz0cL25vv6BQQ8ZCmxWta65PGdoeGR0bHyiBgQgEnod4ORUfnpmVszN220CFhbE4tLyyura+m+ARG5+zwVuiM0te7vAxZC8jCZwZ9cpFvfcTGsCDbT7xv0HuH9weHR8kj8tneXOTVYOck8DaF9ciqtrcVO6vbu32gE0rYfHp+eX17dy2QkHSoOwPiWgab9/fH7ZpuOgGLKfmRBg7WiwLMu7mpWWgUl4OFR1gPUnBmD57ES10sBlMwmqGSTsMKCALyD+FUi8gT+Zp2S3H4idGIELIHsSCDgzHkCqTPQFZhKstogDBWtK2ZDgklM++sBmUWB/VOWmSkztBuLd8tuQJAzXJSvFA8ioGSa6uarR0y4AKmXD/ArGGQidmv/kdwCIhY2HZC8p8fRljHgA2YigqsVnrbQMJ4YoA78BjMQfC7rrIdgAAAAASUVORK5CYII="
                                        alt="">
                                    <p>Comparte esta petición en persona o usa el código QR en tu propio material.</p>
                                </div>
                                <a href="#" class="btn btn-outline-light w-100 fw-bold">Descargar código QR</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="row row-cols-4 g-3 text-center">
                            <div class="col">
                                <a href="#" class="text-reset text-decoration-none small">
                                    <span
                                        class="circulo d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary fs-4 mb-1">
                                        <i class="bi bi-link-45deg"></i>
                                    </span><br>
                                    Copiar enlace
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="text-reset text-decoration-none small">
                                    <span
                                        class="circulo d-inline-flex align-items-center justify-content-center rounded-circle bg-success fs-4 mb-1">
                                        <i class="bi bi-whatsapp"></i>
                                    </span><br>
                                    WhatsApp
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="text-reset text-decoration-none small">
                                    <span
                                        class="circulo d-inline-flex align-items-center justify-content-center rounded-circle bg-primary fs-4 mb-1">
                                        <i class="bi bi-facebook"></i>
                                    </span><br>
                                    Facebook
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="text-reset text-decoration-none small">
                                    <span
                                        class="circulo d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-dark fs-4 mb-1">
                                        <i class="bi bi-twitter-x"></i>
                                    </span><br>
                                    X
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="text-reset text-decoration-none small">
                                    <span
                                        class="circulo d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary fs-4 mb-1">
                                        <i class="bi bi-envelope"></i>
                                    </span><br>
                                    Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="m">
                    <p>Petición creada el {{ $peticion->created_at?->format('d/m/Y') }}</p>
                </div>
                <hr>
                <div>
                    <div class="breadcrumb">
                        <a class="breadcrumb-item" href="#">Change.org</a>
                        <a class="breadcrumb-item" href="#">Tema</a>
                        <a class="breadcrumb-item" href="#">{{ $peticion->categoria?->nombre }}</a>
                    </div>
                    <p class="mb-5">{{ $peticion->titulo }}</p>
                    <hr>
                </div>
                <div id="patrocinadas">
                    <h2 class="h4 fw-bold mb-3">Peticiones patrocinadas por otros usuarios de Change.org</h2>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-01.webp') }}"
                                    class="card-img-top" alt="Ciudadanos Navarra">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 70 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Solicitar una Unidad de Ciudadanos Paliativos
                                        Pediátricos en Navarra</h3>
                                    <p class="small text-body-secondary">Navarra, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 3139 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/landing-07.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 128 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Garantizar acceso a terapia hormonal para
                                        menopausia con pauta médica</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 34.264 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-02.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 415 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">MOAÑA NO OLVIDA: ¿CUÁNTOS PERROS MÁS TIENEN
                                        QUE SUFRIR?</h3>
                                    <p class="small text-body-secondary">Meira, Moaña, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 39.694 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-03.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 258 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Apoyemos la huelga docente en Madrid</h3>
                                    <p class="small text-body-secondary">Madrid, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 26.337 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-04.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 8 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">¡POR UN COLEGIO DIGNO! EL CEIP MIGUEL DE
                                        UNAMUNO NECESITA SOLUCIONES URGENTES</h3>
                                    <p class="small text-body-secondary">Comunidad de Madrid, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 245 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-05.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 37 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">¿QUÉ PASA CON ASAMIMER? 40 AÑOS en Villarcayo
                                        y ahora se lo quieren llevar</h3>
                                    <p class="small text-body-secondary">Villarcayo, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 1660 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-06.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 38 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Perque no mori el Belverede, l'hotel
                                        emblematic de Cerbère</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 1284 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-07.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 1 firmante</a>
                                    <h3 class="card-title h6 fw-bold mt-1">¡Salvemos el fútbol sala base valenciano!
                                        Exigimos soluciones urgentes a la FFCV</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 408 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-08.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 1 firmante</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Incluir Lecanemab y Donanemab en medicamentos
                                        subvencionados</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 33 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-09.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 1107 firmante</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Cotizamos más de 40 años. Exigimos jubilarnos
                                        sin penalización</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 60.298 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-10.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 2 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Prohibir el uso de pirotecnia en zonas
                                        residenciales</h3>
                                    <p class="small text-body-secondary">Ceutí, España</p>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 473 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('img/listado-11.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button type="submit"
                                    class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="small text-body-secondary">Patrocinada por 1 firmantes</a>
                                    <h3 class="card-title h6 fw-bold mt-1">Sacar a los partidos políticos de las
                                        instituciones</h3>
                                    <p class="fw-bold mt-auto"><i class="bi bi-vector-pen"></i> 30 firmas</p>
                                    <a href="{{ route('peticiones.index') }}" class="btn btn-outline-light">Firma esta petición</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="patrocinadas">
                    <h2 class="h4 fw-bold mb-3">Victorias</h2>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        <div class="col">
                            <div class="card h-80 shadow-sm">
                                <img src="{{ asset('img/detalle-03.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button
                                    class="btn bg-secondary rounded-5 position-absolute top-0 start-0 m-2 text-black fw-bold">Victoria</button>
                                <button class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5 fw-bold mt-1 mb-4">Tengo 78 años y me siento apartado por
                                        los bancos. ATENCIÓN HUMANA EN SUCURSALES BANCARIAS</h3>
                                    <p class="fw-bold mb-0"><i class="bi bi-vector-pen"></i> 647.516 firmas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-80 shadow-sm">
                                <img src="{{ asset('img/detalle-04.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button
                                    class="btn bg-secondary rounded-5 position-absolute top-0 start-0 m-2 text-black fw-bold">Victoria</button>
                                <button class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5 fw-bold mt-1 mb-4">URGENTE: Unidades Especializadas para
                                        los Trastornos de la Conducta Alimentaria ¡YA!</h3>
                                    <p class="fw-bold mb-0"><i class="bi bi-vector-pen"></i> 381.848 firmas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-80 shadow-sm">
                                <img src="{{ asset('img/detalle-05.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button
                                    class="btn bg-secondary rounded-5 position-absolute top-0 start-0 m-2 text-black fw-bold">Victoria</button>
                                <button class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5 fw-bold mt-1 mb-4">Mi madre se ha suicidado. Hoy lo harán
                                        10 más ☎Teléfono público de prevención suicidios YA</h3>
                                    <p class="fw-bold mb-0"><i class="bi bi-vector-pen"></i> 96.234 firmas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-80 shadow-sm">
                                <img src="{{ asset('img/detalle-06.webp') }}"
                                    class="card-img-top" alt="Bicicleta">
                                <button
                                    class="btn bg-secondary rounded-5 position-absolute top-0 start-0 m-2 text-black fw-bold">Victoria</button>
                                <button class="btn bg-secondary rounded-circle position-absolute top-0 end-0 m-2"><i
                                        class="bi bi-arrow-right text-black"></i></button>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5 fw-bold mt-1 mb-4">No habrá paz para los malvados. Para que
                                        los delitos sexuales contra menores no prescriban</h3>
                                    <p class="fw-bold mb-0"><i class="bi bi-vector-pen"></i> 566.797 firmas</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    
    </div>
@endsection
