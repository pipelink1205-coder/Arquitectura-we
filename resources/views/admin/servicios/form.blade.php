@extends('admin.layout')

@section('titulo', $servicio->exists ? 'Editar servicio' : 'Nuevo servicio')

@section('contenido')
    <div class="admin-top">
        <h2>{{ $servicio->exists ? 'Editar servicio' : 'Nuevo servicio' }}</h2>
        <a class="admin-btn admin-btn--line" href="{{ route('admin.servicios.index') }}">Volver</a>
    </div>
    <div class="admin-card">
        <form class="admin-form" method="post" enctype="multipart/form-data" action="{{ $servicio->exists ? route('admin.servicios.update', $servicio) : route('admin.servicios.store') }}">
            @csrf
            @if ($servicio->exists)
                @method('PUT')
            @endif

            <label>Título
                <input type="text" name="titulo" value="{{ old('titulo', $servicio->titulo) }}" required>
            </label>
            <label>Descripción
                <textarea name="texto" required>{{ old('texto', $servicio->texto) }}</textarea>
            </label>
            <div class="admin-row">
                <label>Ancho imagen (px)
                    <input type="number" name="w" value="{{ old('w', $servicio->w ?: 800) }}" required>
                </label>
                <label>Alto imagen (px)
                    <input type="number" name="h" value="{{ old('h', $servicio->h ?: 800) }}" required>
                </label>
            </div>
            <label>Texto alternativo (accesibilidad)
                <input type="text" name="alt" value="{{ old('alt', $servicio->alt) }}" required>
            </label>
            <div class="admin-row">
                <label>Orden
                    <input type="number" name="orden" value="{{ old('orden', $servicio->orden ?? 0) }}" min="0">
                </label>
                <label class="admin-check" style="align-self:end">
                    <input type="checkbox" name="activo" value="1" @checked(old('activo', $servicio->exists ? $servicio->activo : true))> Visible en la web
                </label>
            </div>
            <label>Foto @unless($servicio->exists)<span style="font-weight:400">(requerida)</span>@endunless
                @if ($servicio->img)
                    <img src="{{ asset($servicio->img) }}" alt="" style="width:120px;height:120px;object-fit:cover;border-radius:6px">
                @endif
                <input type="file" name="foto" accept="image/*" @unless($servicio->exists) required @endunless>
            </label>
            <button type="submit" class="admin-btn">Guardar</button>
        </form>
    </div>
@endsection
