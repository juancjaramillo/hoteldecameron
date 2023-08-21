<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitacionesTable extends Migration
{
    public function up()
    {
        Schema::create('habitacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('tipo_habitacion_id');
            $table->integer('cantidad');
            $table->string('acomodacion');
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('tipo_habitacion_id')->references('id')->on('tipos_habitacion')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('habitacions');
    }
}
