<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    public function index()
    {
        $tiposHabitacion = TipoHabitacion::all();
        return response()->json($tiposHabitacion);
    }

    public function store(Request $request)
    {
        $tipoHabitacion = TipoHabitacion::create($request->all());
        return response()->json($tipoHabitacion, 201);
    }

    public function show($id)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($id);
        return response()->json($tipoHabitacion);
    }

    public function update(Request $request, $id)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($id);
        $tipoHabitacion->update($request->all());
        return response()->json($tipoHabitacion, 200);
    }

    public function destroy($id)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($id);
        $tipoHabitacion->delete();
        return response()->json(null, 204);
    }
}
