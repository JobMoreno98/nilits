<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('usuario')->insert([
            'nombre' => 'usuarioEjemplo',
            'pass' => hash('sha1', 'contraseñaEjemplo'),  // Usa SHA-1 para el hash
            'nivel' => 2,  // Ajusta el nivel según sea necesario
        ]);
    }
}
