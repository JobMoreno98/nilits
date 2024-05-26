<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alumnos')->insert([
            ['codigo' => 'A001', 'id_tutor' => 'T001', 'Activo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['codigo' => 'A002', 'id_tutor' => 'T002', 'Activo' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Añade más registros según sea necesario
        ]);
    }
}
