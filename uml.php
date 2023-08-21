<?php

class Hotel {
    private $id;
    private $nombre;
    private $direccion;
    private $ciudad;
    private $nit;
    private $numeroHabitaciones;
    private $habitaciones = [];

    public function agregarHabitacion(Habitacion $habitacion) {
        // Lógica para agregar una habitación al hotel
        $this->habitaciones[] = $habitacion;
    }

    // Otros métodos y propiedades relevantes
}

class Habitacion {
    private $id;
    private $tipo;
    private $acomodacion;

    public function __construct($tipo, $acomodacion) {
        $this->tipo = $tipo;
        $this->acomodacion = $acomodacion;
    }

    // Otros métodos y propiedades relevantes
}

class TipoHabitacion {
    private $id;
    private $nombre;
    private $acomodacionesPermitidas = [];

    public function __construct($nombre, array $acomodaciones) {
        $this->nombre = $nombre;
        $this->acomodacionesPermitidas = $acomodaciones;
    }

    // Otros métodos y propiedades relevantes
}
?>