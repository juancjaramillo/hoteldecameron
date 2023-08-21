<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class HotelController extends Controller
{
   /* public function index()
    {
        $hoteles = Hotel::all();
        return response()->json($hoteles);
    }*/

    public function index()
    {
        $hoteles = Hotel::all();
        return view('index', compact('hoteles'));
    }

    public function store(Request $request)
    {
        try {
            $nit = $request->input('nit');

            $existingHotel = Hotel::where('nit', $nit)->first();
            if ($existingHotel) {
                return redirect()->route('hotels.create')
                    ->withInput($request->all())
                    ->withErrors(['nit' => 'El NIT ingresado ya está registrado.']);
            }

            $hotel = Hotel::create($request->all());
            return redirect()->route('hotels.index'); // Redirige a la página de lista de hoteles
        } catch (QueryException $e) {
            return redirect()->route('hotels.create')
                ->withInput($request->all())
                ->withErrors(['error' => 'Error al crear el hotel.']);
        }
    }

    public function edit(Hotel $hotel)
    {
        $tipoHabitaciones = TipoHabitacion::all();

        // Obtener las habitaciones agregadas para este hotel
        $habitacionesAgregadas = $hotel->habitaciones;

        return view('edit', [
            'hotel' => $hotel,
            'tipoHabitaciones' => $tipoHabitaciones,
            'habitacionesAgregadas' => $habitacionesAgregadas,
        ]);
    }
    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
       // return response()->json($hotel, 200);
        return redirect()->route('hotels.index')->with('success', 'Hotel actualizado correctamente.');
    }


    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(null, 204);
    }

public function create()
{
    return view('create');
}


public function addRoom(Request $request, Hotel $hotel)
{
    $request->validate([
        'cantidad' => 'required|integer',
        'tipo_habitacion' => 'required|exists:tipo_habitacions,id',
        'acomodacion' => 'required'

    ]);

     // Validar la suma total de habitaciones
     $totalHabitaciones = $hotel->habitaciones->sum('cantidad');
     if ($totalHabitaciones + $request->cantidad > $hotel->numero_habitaciones) {
         return response()->json(['message' => 'La suma total de habitaciones supera el límite.'], 422);
     }


  // Validar tipos de habitaciones y acomodaciones repetidas
  if ($hotel->habitaciones()->where('tipo_habitacion_id', $request->tipo_habitacion)
  ->where('acomodacion', $request->acomodacion)->exists()) {
  return response()->json(['message' => 'Esta combinación de tipo y acomodación ya existe para este hotel.'], 422);
}

// Crear y guardar la habitación
$habitacion = new Habitacion([
  'cantidad' => $request->cantidad,
  'tipo_habitacion_id' => $request->tipo_habitacion,
  'acomodacion' => $request->acomodacion
]);

    // Crea la habitación asociada al hotel
    $habitacion = new Habitacion([
        'cantidad' => $request->input('cantidad'),
        'acomodacion' => $request->input('acomodacion'),
        'tipo_habitacion_id' => $request->input('tipo_habitacion')
    ]);

    $hotel->habitaciones()->save($habitacion);
    return response()->json($habitacion, 201);

}


}




