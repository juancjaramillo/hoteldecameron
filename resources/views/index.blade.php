@extends('layouts.app')

@section('content')
    <h1>Lista de Hoteles</h1>

    <a href="{{ route('hotels.create') }}" class="btn btn-primary mb-3">Registrar Hotel</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>NIT</th>
                <th>Número de Habitaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hoteles as $hotel)
                <tr>
                    <td>{{ $hotel->nombre }}</td>
                    <td>{{ $hotel->direccion }}</td>
                    <td>{{ $hotel->ciudad }}</td>
                    <td>{{ $hotel->nit }}</td>
                    <td>{{ $hotel->numero_habitaciones }}</td>
                    <td>
                        <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
