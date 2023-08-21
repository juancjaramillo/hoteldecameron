<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposHabitacion = [
            ['nombre' => 'Estándar'],
            ['nombre' => 'Junior'],
            ['nombre' => 'Suite'],
        ];

        DB::table('tipos_habitacion')->insert($tiposHabitacion);
    }
}
