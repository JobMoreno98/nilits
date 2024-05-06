<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class tutorController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Obtener los alumnos asociados al tutor actual y ordenarlos por 'dictamen' de manera descendente
    $alumnos = DB::table('alumnos')
                ->join('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
                ->where('alumno_tutor.id_tutor', '=', $user->nombre)
                ->select('alumnos.*')
                ->orderBy('alumnos.dictamen', 'desc') // Ordenar por 'dictamen' de manera descendente
                ->get();

    // Mapear los resultados para incluir el nombre del estado
    foreach ($alumnos as $alumno) {
        $alumno->nombre_estado = $this->obtenerNombreEstado($alumno->procedencia);
    }

    return view('tutor.index')->with('alumnos', $alumnos);
}


    // Función para obtener el nombre del estado a partir del valor numérico de procedencia
    private function obtenerNombreEstado($procedencia)
    {
        $estados = [
            0 => 'Aguascalientes', 1 => 'Baja California', 2 => 'Baja California Sur', 3 => 'Campeche',
            4 => 'Chiapas', 5 => 'Chihuahua', 6 => 'Ciudad de México', 7 => 'Coahuila', 8 => 'Colima',
            9 => 'Durango', 10 => 'Guanajuato', 11 => 'Guerrero', 12 => 'Hidalgo', 13 => 'Jalisco',
            14 => 'México', 15 => 'Michoacán', 16 => 'Morelos', 17 => 'Nayarit', 18 => 'Nuevo León',
            19 => 'Oaxaca', 20 => 'Puebla', 21 => 'Querétaro', 22 => 'Quintana Roo', 23 => 'San Luis Potosí',
            24 => 'Sinaloa', 25 => 'Sonora', 26 => 'Tabasco', 27 => 'Tamaulipas', 28 => 'Tlaxcala',
            29 => 'Veracruz', 30 => 'Yucatán', 31 => 'Zacatecas'
        ];

        return $estados[$procedencia] ?? 'Desconocido';
    }
}
