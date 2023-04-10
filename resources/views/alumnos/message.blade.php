@extends('layout/template')

@section('title', 'Alumnos | Escuela')

@section('contenido')

<main>
    <div class="container py-4">
        <h1>{{ $msg }}</h1>

<a href="{{url('alumnos')}}"class="btn btn-secondary">Regresar</a>

    </div>
</main>