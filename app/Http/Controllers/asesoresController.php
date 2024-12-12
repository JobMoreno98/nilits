<?php

namespace App\Http\Controllers;

use App\Models\alumno_tutorModel;
use App\Models\alumnos_model;
use App\Models\maestrosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class asesoresController extends Controller
{
    //
    public function index()
    {
        $maestros = DB::table('maestros')->where('activo', 1)->get();

        return view('asesores.index')->with('maestros', $maestros);
    }


    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'correo' => 'required|email',
            // Agrega aquí las validaciones necesarias para los demás campos
        ]);

        // Crear una nueva instancia del modelo Alumno
        $maestro = new maestrosModel();

        // Asignar los valores del formulario al modelo
        $maestro->codigo = $request->codigo;
        $maestro->Nombre = $request->nombre;
        $maestro->Apellido = $request->apellido;
        $maestro->correo = $request->correo;
        $maestro->telefonoFijo = $request->telefono_fijo;
        $maestro->telCel = $request->telefono_celular;
        $maestro->telExt = $request->extension;
        $maestro->nombramiento = $request->nombramiento;
        $maestro->cargaHoraria = $request->carga_horaria;
        $maestro->adscripcion = $request->adscripcion;
        $maestro->grado = $request->grado;
        $maestro->observaciones = $request->observaciones;
        $maestro->activo = 1;

        // Guardar el maestro en la base de datos
        $maestro->save();

        // Redireccionar a una ruta de éxito o mostrar un mensaje de confirmación
        return redirect()->route('asesores')->with('success', 'Alumno guardado correctamente');
    }


    public function actualizarMaestro(Request $request, $codigo)
    {
        $request->validate([
            'Nombre' => 'required',
            'Apellido' => 'required',
            'correo' => 'required',
            'nombramiento' => 'required',
            'cargaHoraria' => 'required',
            'adscripcion' => 'required',
            'grado' => 'required',

        ]);
        // Obtener el maestro a actualizar
        $maestro = maestrosModel::where('codigo', '=', $codigo)->first();


        // Actualizar los datos del maestro
        $maestro->Nombre = $request->Nombre;
        $maestro->Apellido = $request->Apellido;
        $maestro->correo = $request->correo;
        //$maestro->telefonoFijo = $request->telefonoFijo;
        //$maestro->telCel = $request->telCel;
        //$maestro->telExt = $request->telExt;
        $maestro->nombramiento = $request->nombramiento;
        $maestro->cargaHoraria = $request->cargaHoraria;
        $maestro->adscripcion = $request->adscripcion;
        $maestro->grado = $request->grado;
        //$maestro->observaciones = $request->observaciones;


        $maestro->telefonoFijo = $request->filled('telefonoFijo') ? $request->telefonoFijo : ' ';
        $maestro->telCel = $request->filled('telCel') ? $request->telCel : ' ';
        $maestro->telExt = $request->filled('telExt') ? $request->telExt : ' ';
        $maestro->observaciones = $request->filled('observaciones') ? $request->observaciones : ' ';

        // Guardar los cambios en la base de datos
        $maestro->update();

        // Redireccionar o devolver una respuesta JSON según tu necesidad
        return redirect()->route('asesores');
    }

    public function getionarT()
    {
        $maestros = DB::table('maestros')
            ->leftJoin('alumno_tutor', 'maestros.codigo', '=', 'alumno_tutor.id_tutor')
            ->select('maestros.*', DB::raw('COUNT(alumno_tutor.codigo) as NumeroTutorados'))

            ->groupBy('maestros.codigo', 'maestros.id', 'maestros.Nombre', 'maestros.Apellido', 'maestros.grado', 'maestros.nombramiento', 'maestros.cargaHoraria', 'maestros.correo', 'maestros.telefonoFijo', 'maestros.telCel', 'maestros.telExt', 'maestros.observaciones', 'maestros.adscripcion', 'maestros.activo', 'maestros.created_at', 'maestros.updated_at')
            ->get();

        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->whereNull('maestros.codigo')
            ->where('alumnos.estatus', '=', 1) // Filtrar por estatus igual a 1
            ->select('alumnos.*')
            ->paginate(10);

        return view('tutores.index', compact('maestros', 'alumnos'));
    }

    public function getTutorados($maestroId)
    {
        $tutorados = DB::table('alumno_tutor')
            ->join('alumnos', 'alumno_tutor.codigo', '=', 'alumnos.codigo')
            ->where('alumno_tutor.id_tutor', $maestroId)
            ->select('alumnos.*') // Ajusta esto según la estructura de tu tabla de alumnos
            ->get();

        return response()->json($tutorados);
    }
    //Desasigna tutorados de su tutor
    public function desasignar(Request $record, $codigo)
    {

        $record = alumno_tutorModel::where('codigo', '=', $codigo)->first();
        $record->delete();
        return $record;
        return redirect()->route('asesores');
    }


    public function show($id)
    {
        $asesor = maestrosModel::with('tutorados')->first();

        if (!isset($asesor)) {
            alert()->error('Error', 'Asesor no encontrado');
            return redirect()->route('asesores');
        }

        return $asesor;

        $alumnos = alumno_tutorModel::join('alumnos', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->select('alumno_tutor.*', 'alumnos.Nombre as nombre_alumno', 'alumnos.ingreso as ingreso')
            ->where('id_tutor', $asesor->codigo)->where('activo', 1)->orderBy('nombre_alumno')->get();

        return view('asesores.edit', compact('asesor', 'alumnos'));
    }

    public function delete($id)
    {
        $asesor = maestrosModel::find($id);
        if (!isset($asesor)) {
            return redirect()->route('asesores');
        }
        $asesor->activo = 0;
        $asesor->update();
        alert()->success('Exito', 'se elimino de forma correcta al maestro');
        return redirect()->route('asesores');
    }
}
