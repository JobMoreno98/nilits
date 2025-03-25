<?php

namespace App\Http\Controllers;

use App\Mail\ContactanosMailable;
use Illuminate\Http\Request;
use App\Models\alumno_tutorModel;
use App\Models\alumnos_model;
use App\Models\maestrosModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class aspirantesController extends Controller
{
    public $estados = [
        0 => 'Aguascalientes',
        1 => 'Baja California',
        2 => 'Baja California Sur',
        3 => 'Campeche',
        4 => 'Chiapas',
        5 => 'Chihuahua',
        6 => 'Ciudad de México',
        7 => 'Coahuila',
        8 => 'Colima',
        9 => 'Durango',
        10 => 'Guanajuato',
        11 => 'Guerrero',
        12 => 'Hidalgo',
        13 => 'Jalisco',
        14 => 'México',
        15 => 'Michoacán',
        16 => 'Morelos',
        17 => 'Nayarit',
        18 => 'Nuevo León',
        19 => 'Oaxaca',
        20 => 'Puebla',
        21 => 'Querétaro',
        22 => 'Quintana Roo',
        23 => 'San Luis Potosí',
        24 => 'Sinaloa',
        25 => 'Sonora',
        26 => 'Tabasco',
        27 => 'Tamaulipas',
        28 => 'Tlaxcala',
        29 => 'Veracruz',
        30 => 'Yucatán',
        31 => 'Zacatecas',
        32 => 'Desconocida'
    ];

    public function index()
    {
        return view('aspirantes.index')->with('estados', $this->estados);
    }

    // creación de un nuevo Aspirante
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:alumnos,codigo',
            'nombre' => 'required',
            'telefono' => 'required',
            'sexo' => 'required',
            'procedencia' => 'required',
            'correo' => ['required', 'email', Rule::unique('alumnos')->where(fn(Builder $query) => $query->where('deleted_at', null))],
            'fechaNac' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'error' => true,
                'message' => implode("<br/>", $validator->messages()->all()),
            ])->withInput($request->all());
        }

        $alumno = new alumnos_model();

        $alumno->codigo = $request['codigo'];
        $alumno->Nombre = $request['nombre'];
        $alumno->telefono = $request['telefono'];
        $alumno->correo = $request['correo'];
        $alumno->sexo = $request['sexo'];
        $alumno->procedencia = $request['procedencia'];
        $alumno->fechaNac = $request['fechaNac'];
        $alumno->dictamen = null;
        $alumno->estatus = 1;
        $alumno->edad = ' ';
        $alumno->tipo = 'N/A';
        $alumno->modalidad = 'N/A';
        $alumno->evaluacion = 0;
        $alumno->tipoTitulacion = 'N/A';
        $alumno->fechaTitulacion = '2000-01-01';
        $alumno->calendarioTitulacion = ' ';
        $alumno->libro = ' ';
        $alumno->ingreso = ' ';
        $alumno->acta = ' ';
        $alumno->libro = ' ';
        $alumno->revisado = 0;
        $alumno->carrera = 'NILITS';
        $alumno->ciclo = '';

        $alumno->save();

        Mail::to($alumno->correo)->send(new ContactanosMailable($alumno));

        return redirect()->back()->with('success', 'ASPIRANTE creado exitosamente y correo de confirmación enviado.');
    }


    public function admin()
    {
        $aspirantes = alumnos_model::where('revisado', 0)->get();
        $tutores = maestrosModel::orderBy('nombre')->where('activo', 1)->get();
        return view('aspirantes.listado', compact('aspirantes', 'tutores'))->with('estados', $this->estados);
    }
    //funcion para solo poder ver a los alumnos
    public function alumnado_restringido()
    {
        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor_nombre', 'maestros.Apellido as tutor_apellido')
            ->orderBy('alumnos.codigo', 'desc')
            ->paginate(10);
        // Solo mostrar a los alumnos con tutor y aplicar paginación
        /* $alumnos = DB::table('alumnos')
        ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor')
            ->paginate(10); */ // Aquí especificas cuántos alumnos por página quieres

        foreach ($alumnos as $alumno) {
            $alumno->nombre_estado = $this->obtenerNombreEstado($alumno->procedencia);
        }

        // Listar a los maestros para poder asignarlos al crear un registro
        $tutores = maestrosModel::all();

        return view('almunado.index', compact('totalRegistros', 'tutores', 'totalEgresados', 'totalActivos', 'totalBajas', 'alumnos'));
    }

    //Mostrar alumnos sin tutor
    public function alumno_sin_tutor()
    {
        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->whereNull('maestros.codigo')
            ->where('alumnos.estatus', '=', 1) // Filtrar por estatus igual a 1
            ->select('alumnos.*')
            ->paginate(10);

        $tutores = maestrosModel::all();

        return view('alumnos.alumnos_sin_tutor', compact('alumnos', 'tutores'));
    }

    public function detalles($codigo)
    {
        $alumno = alumnos_model::where('codigo', $codigo)->first(); // Obtener los detalles del alumno según su código

        return response()->json($alumno); // Devolver la vista parcial con los detalles del alumno
    }

    // Función para crear un nuevo Aspirante
    //update function
    public function editar(Request $request, $codigo)
    {
        // Obtener el alumno a actualizar
        $alumno = alumnos_model::where('codigo', '=', $request->codigo)->first();

        // Actualizar los datos del alumno
        $alumno->Nombre = $request->nombre;
        $alumno->correo = $request->correo;
        $alumno->calendarioTitulacion = $request->calendarioTitulacion;
        $alumno->ingreso = $request->ingreso;

        $alumno->update();
        // Verificar si el campo de sexo está presente en la solicitud y asignarlo al modelo
        if ($request->filled('sexo')) {
            $alumno->sexo = $request->sexo;
        }

        // Verificar si el campo de procedencia está presente en la solicitud y asignarlo al modelo
        if ($request->filled('procedencia')) {
            $alumno->procedencia = $request->procedencia;
        }

        // Verificar si el campo de fecha de nacimiento está presente en la solicitud y asignarlo al modelo
        if ($request->filled('fechaNac')) {
            $alumno->fechaNac = $request->fechaNac;
        }

        // Verificar si el campo de dictamen está presente en la solicitud y asignarlo al modelo
        if ($request->filled('dictamen')) {
            $alumno->dictamen = $request->dictamen;
        }

        // Verificar si el campo de estatus está presente en la solicitud y asignarlo al modelo
        if ($request->filled('estatus')) {
            $alumno->estatus = $request->estatus;
        }

        // Verificar si el campo de teléfono está presente en la solicitud y asignarlo al modelo
        if ($request->filled('telefono')) {
            $alumno->telefono = $request->telefono;
        }

        // Guardar los cambios en la base de datos
        $alumno->update();


        //return $alumno;

        // Redireccionar o devolver una respuesta JSON según tu necesidad
        return redirect()->route('alumnos');
    }

    public function asignacion(Request $request)
    {
        $validated = $request->validate([
            'maestro' => 'required',
            'alumno' => 'required|array', // Asumiendo que puedes tener múltiples alumnos seleccionados
        ]);

        foreach ($request->alumno as $codigoAlumno) {
            alumno_tutorModel::create([
                'id_tutor' => $request->maestro,
                'codigo' => $codigoAlumno,

            ]);
        }

        return redirect()->route('gestionar-tutores');
    }
}
