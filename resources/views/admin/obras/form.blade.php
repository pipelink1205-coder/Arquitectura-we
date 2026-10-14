@extends('admin.layout')

@section('titulo', $obra->exists ? 'Editar proyecto' : 'Nuevo proyecto')

@section('contenido')
    <div class="admin-top">
        <h2>{{ $obra->exists ? 'Editar proyecto' : 'Nuevo proyecto' }}</h2>
        <a class="admin-btn admin-btn--line" href="{{ route('admin.obras.index') }}">Volver</a>
    </div>
    <div class="admin-card">
        <form class="admin-form" method="post" enctype="multipart/form-data" action="{{ $obra->exists ? route('admin.obras.update', $obra) : route('admin.obras.store') }}">
            @csrf
            @if ($obra->exists)
                @method('PUT')
            @endif

            <label>Categoría
                <select name="cat" required>
                    @foreach ($categorias as $clave => $etiqueta)
                        <option value="{{ $clave }}" @selected(old('cat', $obra->cat) === $clave)>{{ $etiqueta }}</option>
                    @endforeach
                </select>
            </label>
            <label>Título
                <input type="text" name="titulo" value="{{ old('titulo', $obra->titulo) }}" required>
            </label>
            <label>Descripción
                <textarea name="texto" required>{{ old('texto', $obra->texto) }}</textarea>
            </label>
            <label>Etiqueta opcional (reemplaza nombre de categoría en la tarjeta)
                <input type="text" name="etiqueta" value="{{ old('etiqueta', $obra->etiqueta) }}" placeholder="Ej. Diseño y construcción">
            </label>
            <div class="admin-row">
                <label>Ancho (px)
                    <input type="number" name="w" value="{{ old('w', $obra->w ?: 900) }}" required>
                </label>
                <label>Alto (px)
                    <input type="number" name="h" value="{{ old('h', $obra->h ?: 900) }}" required>
                </label>
            </div>
            <label>Texto alternativo
                <input type="text" name="alt" value="{{ old('alt', $obra->alt) }}" required>
            </label>
            <div class="admin-row">
                <label>Orden
                    <input type="number" name="orden" value="{{ old('orden', $obra->orden ?? 0) }}" min="0">
                </label>
                <label class="admin-check" style="align-self:end">
                    <input type="checkbox" name="activo" value="1" @checked(old('activo', $obra->exists ? $obra->activo : true))> Visible en la web
                </label>
            </div>
            <label>Foto @unless($obra->exists)<span style="font-weight:400">(requerida, se guarda en images/obras/)</span>@endunless
                @if ($obra->img)
                    <img src="{{ asset($obra->img) }}" alt="" style="width:120px;height:120px;object-fit:cover;border-radius:6px">
                @endif
                <input type="file" name="foto" accept="image/*" @unless($obra->exists) required @endunless>
            </label>
            <button type="submit" class="admin-btn">Guardar</button>
        </form>
    </div>
@endsection
