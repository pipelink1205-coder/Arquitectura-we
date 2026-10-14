@extends('admin.layout')

@section('titulo', 'Servicios')

@section('contenido')
    <div class="admin-top">
        <h2>Servicios</h2>
        <a class="admin-btn" href="{{ route('admin.servicios.create') }}">Nuevo servicio</a>
    </div>
    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Título</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $servicio)
                    <tr>
                        <td><img src="{{ asset($servicio->img) }}" alt=""></td>
                        <td>{{ $servicio->titulo }}</td>
                        <td>{{ $servicio->orden }}</td>
                        <td>{{ $servicio->activo ? 'Visible' : 'Oculto' }}</td>
                        <td>
                            <div class="admin-actions">
                                <a class="admin-btn admin-btn--line" href="{{ route('admin.servicios.edit', $servicio) }}">Editar</a>
                                <form method="post" action="{{ route('admin.servicios.destroy', $servicio) }}" onsubmit="return confirm('¿Eliminar este servicio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay servicios. Crea uno o importa con el seeder.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
