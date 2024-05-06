<?php

namespace App\Http\Controllers;

//use Barryvdh\DomPDF\PDF as PDF;

use App\Models\maestrosModel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PDFController extends Controller
{
    //

    public function oficioAsignacion(Request $request)
{


    $codigoMaestro = $request->input('codigo');
    $maestro = DB::table('maestros')
                 ->where('codigo', $codigoMaestro)
                 ->first();

    // Luego, obtén la lista de tutorados asociados a este maestro
    $tutorados = DB::table('alumno_tutor')
                   ->join('alumnos', 'alumno_tutor.codigo', '=', 'alumnos.codigo')
                   ->where('alumno_tutor.id_tutor', $codigoMaestro)
                   ->select('alumnos.*')
                   ->get();

    $half = ceil($tutorados->count() / 2);

    Carbon::setLocale(LC_ALL,'es_MX.UTF-8'); // Establece el idioma de Carbon


     // Traducción de los nombres de los meses al español
     $meses = [
         'January' => 'enero',
         'February' => 'febrero',
         'March' => 'marzo',
         'April' => 'abril',
         'May' => 'mayo',
         'June' => 'junio',
         'July' => 'julio',
         'August' => 'agosto',
         'September' => 'septiembre',
         'October' => 'octubre',
         'November' => 'noviembre',
         'December' => 'diciembre',
     ];

     // Formatea la fecha manualmente con los nombres de los meses en español
     $fechaActual = Carbon::now()->format('d \d\e F \d\e Y');

     foreach ($meses as $mesIngles => $mesEspanol) {
         $fechaActual = str_replace($mesIngles, $mesEspanol, $fechaActual);
     }

    $pdf = PDF::loadView('pdf.oficio_asignacion',['maestro' => $maestro,
    'tutorados' => $tutorados, 'half'=>$half, 'fechaActual'=>$fechaActual]);

    return $pdf->download('oficio_asignacion.pdf');
}

public function constanciaTutoria(Request $request)
{
    $codigoMaestro = $request->input('codigo');
    $maestro = DB::table('maestros')
                 ->where('codigo', $codigoMaestro)
                 ->first();

    // Luego, obtén la lista de tutorados asociados a este maestro
    $tutorados = DB::table('alumno_tutor')
                   ->join('alumnos', 'alumno_tutor.codigo', '=', 'alumnos.codigo')
                   ->where('alumno_tutor.id_tutor', $codigoMaestro)
                   ->select('alumnos.*')
                   ->get();

    $half = ceil($tutorados->count() / 2);
     // Tus datos aquí

     Carbon::setLocale(LC_ALL,'es_MX.UTF-8'); // Establece el idioma de Carbon


     // Traducción de los nombres de los meses al español
     $meses = [
         'January' => 'enero',
         'February' => 'febrero',
         'March' => 'marzo',
         'April' => 'abril',
         'May' => 'mayo',
         'June' => 'junio',
         'July' => 'julio',
         'August' => 'agosto',
         'September' => 'septiembre',
         'October' => 'octubre',
         'November' => 'noviembre',
         'December' => 'diciembre',
     ];

     // Formatea la fecha manualmente con los nombres de los meses en español
     $fechaActual = Carbon::now()->format('d \d\e F \d\e Y');

     foreach ($meses as $mesIngles => $mesEspanol) {
         $fechaActual = str_replace($mesIngles, $mesEspanol, $fechaActual);
     }

    $pdf = PDF::loadView('pdf.constancia_tutoria',['maestro' => $maestro,
    'tutorados' => $tutorados, 'fechaActual'=>$fechaActual]);
    return $pdf->download('constancia_tutoria.pdf');
}
}
