@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
<br>
                <div class="mb-3">
                    <a href="{{ route('hotels.index') }}" class="btn btn-success">Volver a la lista de hoteles</a>
                </div>
                <div class="card">
                    <div class="card-header">Registrar Hotel</div>

                    <div class="card-body">
                        <form action="{{ route('hotels.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre del Hotel</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                            </div>
                            <div class="form-group">
                                <label for="nit">NIT</label>
                                <input type="text" class="form-control" id="nit" name="nit" required>
                            </div>
                            <div class="form-group">
                                <label for="numero_habitaciones">Número de Habitaciones</label>
                                <input type="number" class="form-control" id="numero_habitaciones"
                                    name="numero_habitaciones" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#showAddRoomForm').on('click', function () {
                    $('#addRoomFormContainer').toggle();

                    // Restablecer opciones de acomodación al cambiar el tipo de habitación
                    $('#tipo_habitacion').on('change', function () {
                        $('#acomodacion').empty();
                    });

                    // Cargar tipos de habitación desde la base de datos
                    $.ajax({
                        url: "{{ route('roomTypes.index') }}",
                        method: 'GET',
                        success: function (response) {
                            var tipoHabitacionSelect = $('#tipo_habitacion');
                            tipoHabitacionSelect.empty();
                            $.each(response, function (index, roomType) {
                                tipoHabitacionSelect.append($('<option>', {
                                    value: roomType.id,
                                    text: roomType.nombre
                                }));
                            });

                            // Cargar acomodación según el tipo de habitación seleccionado
                            tipoHabitacionSelect.on('change', function () {
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
                });

                $('#registerRoomButton').on('click', function () {
                    var tipoHabitacion = $('#tipo_habitacion').val();
                    var acomodacion = $('#acomodacion').val();
                    var cantidad = parseInt($('#cantidad').val());
                    var cantidadHabitaciones = parseInt($('#numero_habitaciones').val());
                    var cantidadRegistrada = 0;

                    if (!tipoHabitacion || !acomodacion || !cantidad) {
                        alert('Por favor completa todos los campos');
                        return;
                    }

                    // Obtener la cantidad total de habitaciones registradas
                    $('.habitacion-cantidad').each(function () {
                        cantidadRegistrada += parseInt($(this).text());
                    });

                    // Verificar si la cantidad total supera el límite
                    if (cantidadRegistrada + cantidad > cantidadHabitaciones) {
                        alert('La cantidad total de habitaciones registradas supera el límite.');
                        return;
                    }

                    // Verificar si ya existe una habitación con el mismo tipo y acomodación
                    var duplicado = false;
                    $('.habitacion-tipo').each(function () {
                        var habitacionTipo = $(this).text();
                        var habitacionAcomodacion = $(this).data('acomodacion');
                        if (habitacionTipo === tipoHabitacion && habitacionAcomodacion === acomodacion) {
                            duplicado = true;
                            return false; // Salir del bucle
                        }
                    });

                    if (duplicado) {
                        alert('Ya existe una habitación con el mismo tipo y acomodación.');
                        return;
                    }

                    // Agregar registro a la lista
                    $('#addedRoomsList').append('<p class="habitacion-tipo" data-acomodacion="' + acomodacion + '">Tipo: ' + tipoHabitacion + ', Acomodación: ' + acomodacion + ', Cantidad: ' + cantidad + '</p>');
                });
            });
        </script>
    </div>
@endsection
