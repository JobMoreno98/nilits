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

    public function oficioAsignacion($id)
    {

        $maestro = maestrosModel::with('tutorados')->where('id',$id)->first();

        Carbon::setLocale(LC_ALL, 'es_MX.UTF-8'); // Establece el idioma de Carbon


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

        $pdf = PDF::loadView('pdf.oficio_asignacion', [
            'maestro' => $maestro,
            'fechaActual' => $fechaActual
        ]);

        return $pdf->stream('oficio_asignacion.pdf');
    }

    public function constanciaTutoria($id)
    {

        $maestro = maestrosModel::with('tutorados')->where('id',$id)->first();

        Carbon::setLocale(LC_ALL, 'es_MX.UTF-8'); // Establece el idioma de Carbon


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

        $pdf = PDF::loadView('pdf.constancia_tutoria', [
            'maestro' => $maestro,
            'fechaActual' => $fechaActual
        ]);
        return $pdf->stream('constancia_tutoria.pdf');
    }
}
