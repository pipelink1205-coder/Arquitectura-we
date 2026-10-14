@extends('admin.layout')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="admin-top">
        <h2>Resumen</h2>
    </div>
    <div class="admin-row">
        <div class="admin-card">
            <strong style="font-size:2rem">{{ $servicios }}</strong>
            <p style="margin:8px 0 0;color:#5a606b">Servicios en base de datos</p>
            <p style="margin-top:16px"><a class="admin-btn" href="{{ route('admin.servicios.index') }}">Gestionar servicios</a></p>
        </div>
        <div class="admin-card">
            <strong style="font-size:2rem">{{ $obras }}</strong>
            <p style="margin:8px 0 0;color:#5a606b">Proyectos en portafolio</p>
            <p style="margin-top:16px"><a class="admin-btn" href="{{ route('admin.obras.index') }}">Gestionar proyectos</a></p>
        </div>
    </div>
@endsection
