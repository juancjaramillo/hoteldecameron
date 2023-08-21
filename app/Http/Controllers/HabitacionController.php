<?php

namespace App\Http\Controllers;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index()
    {
        $habitaciones = Habitacion::with(['hotel', 'tipoHabitacion'])->get();
        return response()->json($habitaciones);
    }
    public function store(Request $request)
    {
        $hotelId = $request->hotel_id;
        $cantidadRegistrada = Habitacion::where('hotel_id', $hotelId)->sum('cantidad');
        $cantidadHabitaciones = $request->input('numero_habitaciones');
        $cantidadNueva = $request->input('cantidad');

        if ($cantidadRegistrada === null || $cantidadRegistrada === 0) {
            $cantidadRegistrada = 0;
        }

        if ($cantidadRegistrada + $cantidadNueva > $cantidadHabitaciones) {
            return redirect()->route('hotels.edit', ['hotel' => $hotelId])
                ->withErrors(['error' => 'La cantidad total de habitaciones registradas supera el límite.']);
        }

        // Validar si ya existe una habitación con el mismo tipo y acomodación en este hotel
        $tipoHabitacionId = $request->tipo_habitacion_id;
        $acomodacion = $request->acomodacion;

        $existingRoom = Habitacion::where('hotel_id', $hotelId)
            ->where('tipo_habitacion_id', $tipoHabitacionId)
            ->where('acomodacion', $acomodacion)
            ->first();

        if ($existingRoom) {
            return redirect()->route('hotels.edit', ['hotel' => $hotelId])
                ->withErrors(['error' => 'Ya existe una habitación con el mismo tipo y acomodación en este hotel.']);
        }

        $habitacion = Habitacion::create($request->all());

        return redirect()->route('hotels.edit', ['hotel' => $hotelId])
            ->with('success', 'Habitación agregada exitosamente.');
    }

    public function show($id)
    {
        $habitacion = Habitacion::with(['hotel', 'tipoHabitacion'])->findOrFail($id);
        return response()->json($habitacion);
    }

    public function update(Request $request, $id)
    {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->update($request->all());
        return response()->json($habitacion, 200);
    }
    public function destroy($id)
    {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->delete();
        return response()->json(null, 204);
    }
}
