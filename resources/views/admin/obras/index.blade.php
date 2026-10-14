@extends('admin.layout')

@section('titulo', 'Proyectos')

@section('contenido')
    <div class="admin-top">
        <h2>Proyectos (portafolio)</h2>
        <a class="admin-btn" href="{{ route('admin.obras.create') }}">Nuevo proyecto</a>
    </div>
    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obras as $obra)
                    <tr>
                        <td><img src="{{ asset($obra->img) }}" alt=""></td>
                        <td>{{ $obra->titulo }}</td>
                        <td>{{ $categorias[$obra->cat] ?? $obra->cat }}</td>
                        <td>{{ $obra->orden }}</td>
                        <td>{{ $obra->activo ? 'Visible' : 'Oculto' }}</td>
                        <td>
                            <div class="admin-actions">
                                <a class="admin-btn admin-btn--line" href="{{ route('admin.obras.edit', $obra) }}">Editar</a>
                                <form method="post" action="{{ route('admin.obras.destroy', $obra) }}" onsubmit="return confirm('¿Eliminar este proyecto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay proyectos. Crea uno o importa con el seeder.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
