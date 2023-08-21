@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8"><br>
                <div class="mb-3">
                    <a href="{{ route('hotels.index') }}" class="btn btn-success">Volver a la lista de hoteles</a>
                </div>
                <div class="card">
                    <div class="card-header">Editar Hotel</div>

                    <div class="card-body">
                        <form action="{{ route('hotels.update', $hotel->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre">Nombre del Hotel</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="{{ $hotel->nombre }}" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    value="{{ $hotel->direccion }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad"
                                    value="{{ $hotel->ciudad }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nit">NIT</label>
                                <input type="text" class="form-control" id="nit" name="nit"
                                    value="{{ $hotel->nit }}" required>
                            </div>
                            <div class="form-group">
                                <label for="numero_habitaciones">Número de Habitaciones</label>
                                <input type="number" class="form-control" id="numero_habitaciones"
                                    name="numero_habitaciones" value="{{ $hotel->numero_habitaciones }}" required>
                            </div><br>
                            <button type="submit" class="btn btn-primary">Actualizar</button><br>
                        </form>
                        <br>
                        <div class="card">
                            <div class="card-header">Agregar Habitaciones</div>
                            <div class="card-body">
                                <form id="addRoomForm" action="{{ route('rooms.store') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                    <input type="hidden" id="numero_habitaciones_new" name="numero_habitaciones"
                                        value="{{ $hotel->numero_habitaciones }}">

                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="tipo_habitacion">Tipo de Habitación</label>
                                        <select class="form-control" id="tipo_habitacion" name="tipo_habitacion_id">
                                            <!-- Opciones de tipos de habitación cargadas desde la base de datos -->
                                        </select>
                                        <br>
                                    </div>
                                    <div class="form-group">
                                        <label for="acomodacion">Acomodación</label>
                                        <select class="form-control" id="acomodacion" name="acomodacion">
                                            <!-- Opciones de acomodación según el tipo de habitación -->
                                        </select>
                                    </div><br>
                                    <button type="submit" class="btn btn-primary" id="addRoomButton">Agregar
                                        Habitación</button><BR>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Habitaciones Agregadas</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tipo de Habitación</th>
                                    <th>Acomodación</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="addedRoomsList">
                                <!-- Aquí se mostrarán las habitaciones agregadas -->
                                @foreach ($habitacionesAgregadas as $habitacion)
                                    <tr>
                                        <td>{{ $habitacion->tipoHabitacion->nombre }}</td>
                                        <td>{{ $habitacion->acomodacion }}</td>
                                        <td>{{ $habitacion->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cargar tipos de habitación desde la base de datos

            $.ajax({
                url: "{{ route('roomTypes.index') }}",
                method: 'GET',
                success: function(response) {
                    var tipoHabitacionSelect = $('#tipo_habitacion');
                    tipoHabitacionSelect.empty();
                    tipoHabitacionSelect.append($('<option>', {
                        value: '',
                        text: 'Seleccione un tipo de habitación'
                    }));
                    $.each(response, function(index, roomType) {
                        tipoHabitacionSelect.append($('<option>', {
                            value: roomType.id,
                            text: roomType.nombre
                        }));
                    });

                    // Cargar acomodación según el tipo de habitación seleccionado
                    tipoHabitacionSelect.on('change', function() {
                        var selectedType = tipoHabitacionSelect.val();
                        var acomodacionSelect = $('#acomodacion');
                        acomodacionSelect.empty();

                        if (selectedType === '1') { // Estándar
                            acomodacionSelect.append($('<option>', {
                                value: 'Sencilla',
                                text: 'Sencilla'
                            }));
                            acomodacionSelect.append($('<option>', {
                                value: 'Doble',
                                text: 'Doble'
                            }));
                        } else if (selectedType === '2') { // Junior
                            acomodacionSelect.append($('<option>', {
                                value: 'Triple',
                                text: 'Triple'
                            }));
                            acomodacionSelect.append($('<option>', {
                                value: 'Cuádruple',
                                text: 'Cuádruple'
                            }));
                        } else if (selectedType === '3') { // Suite
                            acomodacionSelect.append($('<option>', {
                                value: 'Sencilla',
                                text: 'Sencilla'
                            }));
                            acomodacionSelect.append($('<option>', {
                                value: 'Doble',
                                text: 'Doble'
                            }));
                            acomodacionSelect.append($('<option>', {
                                value: 'Triple',
                                text: 'Triple'
                            }));
                        }
                    });
                }
            });

            $('#addRoomButton').on('click', function() {
                var tipoHabitacion = $('#tipo_habitacion').val();
                var acomodacion = $('#acomodacion').val();
                var cantidad = $('#cantidad').val();
                var hotelId = "{{ $hotel->id }}"; // Obtener el ID del hotel actual

                if (!tipoHabitacion || !acomodacion || !cantidad) {
                    alert('Por favor completa todos los campos');
                    return;
                }

                // Enviar la petición Ajax para guardar la habitación
                $.ajax({
                    url: "{{ route('rooms.store') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tipo_habitacion: tipoHabitacion,
                        acomodacion: acomodacion,
                        cantidad: cantidad,
                        hotel_id: hotelId
                    },
                    success: function(response) {
                        // Agregar registro a la lista de habitaciones en la página
                        var listItem = $('<li class="list-group-item"></li>').text(
                            'Tipo: ' + tipoHabitacion + ', Acomodación: ' + acomodacion +
                            ', Cantidad: ' + cantidad
                        );
                        $('#addedRoomsList').append(listItem);
                    }
                });
            });
        });
    </script>

    <!--script>
        document.addEventListener("DOMContentLoaded", function() {
            var totalHabitacionesInput = document.getElementById("numero_habitaciones");
            var numeroHabitacionesNewInput = document.getElementById("numero_habitaciones_new");

            totalHabitacionesInput.addEventListener("input", function() {
                var nuevoValor = totalHabitacionesInput.value;
                numeroHabitacionesNewInput.value = nuevoValor;
            });
        });
    </script-->



@endsection
