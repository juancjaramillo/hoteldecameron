<?php
// app/Models/TipoHabitacion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];
    protected $table = 'tipos_habitacion';
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}



