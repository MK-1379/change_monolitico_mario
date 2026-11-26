@extends('layouts.public')

@section('title', 'Editar petición · Change.org')

@section('content')
    <div class="bg-body-secondary pt-3">
        <form action="{{ route('peticiones.update', $peticion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="bg-body rounded-top-3 overflow-hidden">
                    <div class="bg-black py-5">
                        <div class="row justify-content-center mx-0">
                            <div class="col-11 col-lg-8">
                                <span class="barra-roja d-block mb-3"></span>
                                <label for="titulo" class="form-label small">Título</label>
                                <textarea class="form-control bg-black border-light fs-1 fw-bold @error('titulo') is-invalid @enderror" id="titulo" name="titulo" rows="2"
                                    placeholder="Tu título único" maxlength="90" required>{{ old('titulo', $peticion->titulo) }}</textarea>
                                @error('titulo')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mx-0 py-4">
                        <div class="col-11 col-lg-8">
                            <div class="d-flex gap-2 mb-4">
                                <button type="button"
                                    class="btn btn-outline-secondary btn-sm fw-bold p-2 px-3 rounded-3" disabled>
                                    <i class="bi bi-image"></i> Crear imagen
                                </button>
                                <label for="imagen" class="btn btn-outline-light btn-sm fw-bold p-2 px-3 rounded-3">
                                    <i class="bi bi-upload"></i> Añadir fotos
                                </label>
                                <input type="file" class="visually-hidden" id="imagen" name="files[]" accept="image/*" multiple
                                    onchange="document.getElementById('nombreImagen').textContent = this.files.length ? this.files.length + ' imagen(es) nueva(s)' : ''">
                                <span id="nombreImagen" class="small text-body-secondary align-self-center"></span>
                            </div>
                            @if ($peticion->files->isNotEmpty())
                                <p class="small text-body-secondary mb-2">Imágenes actuales. Marca las que quieras eliminar:</p>
                                <div class="d-flex flex-wrap gap-3 mb-4">
                                    @foreach ($peticion->files as $file)
                                        <label class="text-center" for="eliminar{{ $file->id }}">
                                            <img src="{{ asset($file->file_path) }}" class="rounded-3 d-block mb-1" style="height: 110px; width: 150px; object-fit: cover" alt="">
                                            <input type="checkbox" class="form-check-input" name="eliminar[]" id="eliminar{{ $file->id }}" value="{{ $file->id }}"
                                                @checked(in_array($file->id, old('eliminar', [])))>
                                            <span class="small">Eliminar</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @error('files.*')
                                <div class="alert alert-danger py-2"><i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}</div>
                            @enderror

                            <label for="causa" class="h2 fw-bold mb-3">La causa</label>
                            <div class="btn-toolbar bg-primary-subtle border border-bottom-0 rounded-top p-1" role="toolbar" aria-label="Formato de texto">
                                <div class="btn-group me-1">
                                    <button type="button" class="btn btn-sm" aria-label="Negrita"><i class="bi bi-type-bold"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Cursiva"><i class="bi bi-type-italic"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Lista numerada"><i class="bi bi-list-ol"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Lista"><i class="bi bi-list-ul"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Enlace"><i class="bi bi-link-45deg"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Vídeo"><i class="bi bi-play-btn"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Imagen"><i class="bi bi-image"></i></button>
                                    <button type="button" class="btn btn-sm" aria-label="Ayuda"><i class="bi bi-question-circle"></i></button>
                                </div>
                            </div>
                            <textarea class="form-control rounded-top-0 @error('descripcion') is-invalid @enderror" id="causa" name="descripcion" rows="12" minlength="50" required>{{ old('descripcion', $peticion->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                                </div>
                            @enderror
                            <fieldset class="mt-5">
                                <legend class="h2 fw-bold mb-3">¿Dónde quieres lograr el cambio?</legend>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <input type="radio" class="btn-check" name="ambito" id="local" checked>
                                    <label class="btn btn-outline-light" for="local"><i class="bi bi-geo-alt"></i>
                                        Local</label>
                                    <input type="radio" class="btn-check" name="ambito" id="nacional">
                                    <label class="btn btn-outline-light" for="nacional"><i class="bi bi-flag"></i>
                                        Nacional</label>
                                    <input type="radio" class="btn-check" name="ambito" id="global">
                                    <label class="btn btn-outline-light" for="global"><i class="bi bi-globe2"></i>
                                        Global</label>
                                </div>
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion"
                                    placeholder="Ej.: Logroño, La Rioja">
                                <div class="invalid-feedback"><i class="bi bi-exclamation-triangle-fill"></i> Indica la
                                    ubicación.</div>
                            </fieldset>

                            <fieldset class="mt-5">
                                <legend class="h2 fw-bold mb-3">¿Sobre qué tema trata?</legend>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($categorias as $categoria)
                                        <input type="radio" class="btn-check" name="category" id="categoria{{ $categoria->id }}"
                                            value="{{ $categoria->id }}" @checked(old('category', $peticion->categoria_id) == $categoria->id) required>
                                        <label class="btn btn-outline-primary btn-sm" for="categoria{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                                    @endforeach
                                </div>
                                @if ($categorias->isEmpty())
                                    <p class="text-body-secondary">Todavía no hay categorías.</p>
                                @endif
                                @error('category')
                                    <div class="alert alert-danger py-2 mt-2"><i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}</div>
                                @enderror
                            </fieldset>

                            <div class="mt-5">
                                <label for="destinatario" class="h2 fw-bold mb-3">¿Quién puede hacer realidad este cambio?</label>
                                <input type="text" class="form-control @error('destinatario') is-invalid @enderror" id="destinatario" name="destinatario"
                                    value="{{ old('destinatario', $peticion->destinatario) }}" placeholder="Ej.: Ayuntamiento de Logroño" required>
                                @error('destinatario')
                                    <div class="invalid-feedback"><i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-bg-primary bg-gradient py-3">
                <div class="container">
                    <p class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        <strong class="fs-5">Estás editando tu petición</strong>
                        Los cambios se verán en cuanto los guardes.
                    </p>
                </div>
            </div>

            <div class="sticky-bottom bg-body border-top">
                <div class="container d-flex justify-content-end gap-2 py-3">
                    <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn btn-outline-light btn-lg fw-bold">Cancelar</a>
                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Guardar cambios</button>
                </div>
            </div>
        </form>
    
    </div>
@endsection
