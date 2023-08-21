<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function create()
    {
        $roomTypes = TipoHabitacion::all();
        return view('rooms.create', ['roomTypes' => $roomTypes]);
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'hotel_id' => 'required|integer',
            'tipo_habitacion' => 'required|integer',
            'acomodacion' => 'required|string',
            'cantidad' => 'required|integer',
        ]);

        // Obtener datos del formulario
        $hotelId = $request->input('hotel_id');
        $roomTypeId = $request->input('tipo_habitacion');
        $acomodacion = $request->input('acomodacion');
        $cantidad = $request->input('cantidad');

        // Crear y guardar la habitación
        $room = new Habitacion();
        $room->hotel_id = $hotelId;
        $room->tipo_habitacion_id = $roomTypeId;
        $room->acomodacion = $acomodacion;
        $room->cantidad = $cantidad;
        $room->save();


    }

    public function edit($id)
    {
        $room = Habitacion::findOrFail($id);
        $roomTypes = TipoHabitacion::all();
        return view('rooms.edit', ['room' => $room, 'roomTypes' => $roomTypes]);
    }

}
