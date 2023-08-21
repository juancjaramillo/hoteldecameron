<?php
namespace App\Http\Controllers;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{

    public function index()
    {
        $roomTypes = TipoHabitacion::all();
        return response()->json($roomTypes);
    }

}
