<?php

namespace App\Http\Controllers;

use App\Models\alumnos_maestrosModel;
use App\Models\alumnos_model;
use App\Models\maestrosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GraficaExport;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;


class alumnosContorller extends Controller
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

        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        // Obtener las fechas de titulación únicas
        $fechasTitulacion = alumnos_model::select('fechaTitulacion')->distinct()->get();
        $alumnos = alumnos_model::with('tutores')->get();

        // Listar a los maestros para poder asignarlos al crear un registro
        $tutores = maestrosModel::orderBy('nombre')->where('activo', 1)->get();
        return view('alumnos.index', compact('totalRegistros', 'tutores', 'totalEgresados', 'totalActivos', 'totalBajas', 'alumnos', 'fechasTitulacion'));
    }

    public function show(alumnos_model $alumno)
    {
        $estados = $this->estados;
        //in_array($alumno->procedencia, $estados);
        $alumno->procedencia = in_array($alumno->procedencia, array_values($estados)) ? $alumno->procedencia : null;


        return view('alumnos.show', compact('alumno', 'estados'));
    }
    //funcion para solo poder ver a los alumnos
    public function alumnado_restringido()
    {
        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        $alumnos = DB::table('alumnos')
            ->leftJoin('alumnos_maestros', 'alumnos.codigo', '=', 'alumnos_maestros.id_alumno')
            ->leftJoin('maestros', 'alumnos_maestros.id_maestro', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor_nombre', 'maestros.Apellido as tutor_apellido')
            ->orderBy('alumnos.codigo', 'desc')
            ->paginate(10);

        // Solo mostrar a los alumnos con tutor y aplicar paginación
        /* $alumnos = DB::table('alumnos')
            ->leftJoin('alumnos_maestros', 'alumnos.codigo', '=', 'alumnos_maestros.id_alumno')
            ->leftJoin('maestros', 'alumnos_maestros.id_maestro', '=', 'maestros.codigo')
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

    public function sin_tutor()
    {
        $alumnos = alumnos_model::leftJoin('alumno_maestro', 'alumnos.codigo', '=', 'alumno_maestro.alumno_id')
            ->leftJoin('maestros', 'alumno_maestro.maestro_id', '=', 'maestros.codigo')
            ->whereNull('maestros.codigo')
            ->where('alumnos.estatus', '=', 1) // Filtrar por estatus igual a 1
            ->select('alumnos.*')
            ->get();

        $tutores = maestrosModel::all();

        return view('alumnos.alumnos_sin_tutor', compact('alumnos', 'tutores'));
    }

    public function detalles($codigo)
    {
        $alumno = alumnos_model::where('codigo', $codigo)->first(); // Obtener los detalles del alumno según su código

        return response()->json($alumno); // Devolver la vista parcial con los detalles del alumno
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'telefono' => 'required',
            'sexo' => 'required',
            'procedencia' => 'required',
            'correo' => 'required',
            'fechaNac' => 'required',
            'dictamen' => 'required',
            'estatus' => 'required',
            'tutor' => 'required'
            // Agrega aquí el resto de las validaciones necesarias
        ]);

        $alumno = new alumnos_model();
        $tutor_alumno = new alumnos_maestrosModel();
        $alumno->codigo = $validatedData['codigo'];
        $alumno->Nombre = $validatedData['nombre'];
        $alumno->telefono = $validatedData['telefono'];
        $alumno->correo = $validatedData['correo'];
        $alumno->sexo = $validatedData['sexo'];
        $alumno->procedencia = $validatedData['procedencia'];
        $alumno->fechaNac = $validatedData['fechaNac'];
        $alumno->dictamen = $validatedData['dictamen'];
        $alumno->estatus = $validatedData['estatus'];
        $alumno->edad = '0';
        $alumno->tipo = 'N/A';
        $alumno->modalidad = 'N/A';
        $alumno->evaluacion = 0;
        $alumno->tipoTitulacion = 'N/A';
        $alumno->fechaTitulacion = $request->fechaTitulacion ?? '2000-01-01';
        $alumno->calendarioTitulacion = ' ';
        $alumno->libro = ' ';
        $alumno->ingreso = $validatedData['ingreso'];
        $alumno->acta = ' ';
        $alumno->libro = ' ';
        $alumno->revisado = 0;
        $alumno->carrera = 'NILITS';
        $alumno->moda = 'No convencional';
        $tutor_alumno->codigo = $validatedData['codigo'];
        $tutor_alumno->id_tutor = $validatedData['tutor'];
        $tutor_alumno->activo = 1;
        // Asigna el resto de los campos
        $tutor_alumno->save();
        $alumno->save();

        alert()->success('Exito', 'Se regsitro de forma correcta al alumno');
        return redirect()->back()->with('success', 'Alumno creado exitosamente');
    }

    //update function
    public function update(Request $request, $id)
    {
        $alumno = alumnos_model::where('id', $id)->first();
        if (!isset($alumno)) {
            alert()->error('Error', 'Alumno no encontrado');
            return redirect()->route('alumnos');
        }
        $request->validate([
            'nombre' => ['required', Rule::unique('alumnos')->ignore($alumno->id)->where(fn(Builder $query) => $query->where('deleted_at', null))],
            'correo' => 'required|email',
            'calendarioTitulacion' => 'required',
            'ingreso' => 'required',
            'dictamen' => 'required',
            'fechaNac' => 'date'
        ]);
        // Obtener el alumno a actualizar


        $alumno->update([
            'Nombre' => $request->nombre,
            'correo' => $request->correo,
            'ingreso' => $request->ingreso,
            'calendarioTitulacion' =>  $request->calendarioTitulacion,
            'sexo' => isset($request->sexo) ? $request->sexo : 2,
            'procedencia' => $request->procedencia,
            'fechaNac' => isset($request->fechaNac) ? $request->fechaNac : null,
        ]);
        // Verificar si el campo de dictamen está presente en la solicitud y asignarlo al modelo
        if ($request->filled('dictamen')) {
            $alumno->dictamen = implode(".", array_filter($request->dictamen));
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
        toast('<span style="color:#fff;">Se actualizo el alumno</span>', 'success')
            ->autoClose(5000)->timerProgressBar()->position('top-end')->background(' #198754')->toHtml();
        // Redireccionar o devolver una respuesta JSON según tu necesidad
        return redirect()->route('alumnos.show', $alumno->id);
    }


    public function buscar(Request $request)
    {
        $query = $request->input('query');

        // Realizar la consulta para buscar alumnos por nombre

        $alumnos = alumnos_model::where('Nombre', 'like', '%' . $query . '%')
            ->orWhere('alumnos.codigo', 'like', '%' . $query . '%')
            ->paginate(10);
        $tutores = maestrosModel::all();


        // Devolver la vista con los resultados de la búsqueda
        return view('alumnos.alumnos_sin_tutor', ['alumnos' => $alumnos, 'tutores' => $tutores]);
    }

    //busqueda en la seccion de ver alunado
    public function buscarAllRestricted(Request $request)
    {
        $query = $request->input('query');


        $alumnos = DB::table('alumnos')
            ->leftJoin('alumnos_maestros', 'alumnos.codigo', '=', 'alumnos_maestros.id_alumno')
            ->leftJoin('maestros', 'alumnos_maestros.id_maestro', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor_nombre', 'maestros.Apellido as tutor_apellido')
            ->where('alumnos.Nombre', 'like', '%' . $query . '%')
            ->orWhere('alumnos.codigo', 'like', '%' . $query . '%')
            ->paginate(10);


        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        foreach ($alumnos as $alumno) {
            $alumno->nombre_estado = $this->obtenerNombreEstado($alumno->procedencia);
        }
        $tutores = maestrosModel::all();

        // Devolver la vista con los resultados de la búsqueda
        return view('almunado.index', ['alumnos' => $alumnos, 'tutores' => $tutores, 'totalRegistros' => $totalRegistros, 'totalEgresados' => $totalEgresados, 'totalActivos' => $totalActivos, 'totalBajas' => $totalBajas]);
    }


    public function asignacion(Request $request)
    {
        $validated = $request->validate([
            'maestro' => 'required',
            'alumno' => 'required|array', // Asumiendo que puedes tener múltiples alumnos seleccionados
        ]);

        foreach ($request->alumno as $codigoAlumno) {
            alumnos_maestrosModel::create([
                'id_tutor' => $request->maestro,
                'codigo' => $codigoAlumno,
            ]);
        }

        return redirect()->route('gestionar-tutores');
    }

    //solicitud para las gráficas

    public function LlenadoComboBox()
    {
        $opciones = alumnos_model::distinct('tipoTitulacion')->pluck('tipoTitulacion');
        $opcionesHtml = "";

        $opcion = 'Tipo Titulación';
        $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";

        foreach ($opciones as $opcion) {
            $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";
        }

        return response($opcionesHtml);
    }


    public function LlenadoComboBoxDictamen()
    {
        $opciones = alumnos_model::distinct('dictamen')->pluck('dictamen');
        $opcionesHtml = "";

        $opcion = 'Dictamen';
        $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";

        foreach ($opciones as $opcion) {
            $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";
        }

        return response($opcionesHtml);
    }

    public function LlenadoComboBoxCiclo()
    {
        $opciones = alumnos_model::distinct('ciclo')->pluck('ciclo');
        $opcionesHtml = "";

        $opcion = 'Ciclo';
        $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";

        foreach ($opciones as $opcion) {
            $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";
        }

        return response($opcionesHtml);
    }

    public function LlenadoComboBoxIngreso()
    {
        $opciones = alumnos_model::distinct('ingreso')->pluck('ingreso');
        $opcionesHtml = "";

        $opcion = 'Ingreso';
        $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";

        foreach ($opciones as $opcion) {
            $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcion . "</option>";
        }

        return response($opcionesHtml);
    }



    public function LlenadoComboBoxEstatus()
    {
        $opciones = alumnos_model::distinct('estatus')->pluck('estatus');
        $opcionesHtml = "";

        $opcionesMap = [
            1 => 'Activo',
            3 => 'Egresado',
            4 => 'Baja'
        ];

        $opcionesHtml .= "<option value='estatus'>Estatus</option>";

        foreach ($opciones as $opcion) {
            if (isset($opcionesMap[$opcion])) {
                $opcionesHtml .= "<option value='" . $opcion . "'>" . $opcionesMap[$opcion] . "</option>";
            }
        }

        return response($opcionesHtml);
    }


    public function obtenerDatosGrafica(Request $request)
    {
        $showHombres = $request->query('hombres') === 'true';
        $showMujeres = $request->query('mujeres') === 'true';
        $tipoTitulacion = urldecode($request->query('tipoTitulacion'));
        $dictamen = urldecode($request->query('dictamen'));
        $estatus = urldecode($request->query('estatus'));
        $ciclo = urldecode($request->query('ciclo'));
        $ingreso = urldecode($request->query('ingreso'));


        // dd([$showHombres,$showMujeres, $dictamen, $tipoTitulacion, $estatus, $ciclo, $ingreso]);

        $query = alumnos_model::select('sexo', DB::raw('COUNT(*) as count'))
            ->groupBy('sexo');

        if ($estatus && $estatus !== 'estatus') {
            $query->where('estatus', $estatus);
        }

        if ($ciclo && $ciclo !== 'Ciclo') {
            $query->where('ciclo', $ciclo);
        }

        if ($ingreso && $ingreso !== 'Ingreso') {
            $query->where('ingreso', "like", "%$ingreso%");
        }


        if ($dictamen && $dictamen !== 'Dictamen') {
            $query->where('dictamen', $dictamen);
        }

        if ($tipoTitulacion && $tipoTitulacion !==  'Tipo Titulación') {
            $query->where('tipoTitulacion', $tipoTitulacion);
        }



        $counts = $query->get();

        $result = [
            'hombres' => 0,
            'mujeres' => 0,
        ];

        foreach ($counts as $count) {
            if ($count->sexo == '0' && $showHombres) {
                $result['hombres'] = $count->count;
            } elseif ($count->sexo == '1' && $showMujeres) {
                $result['mujeres'] = $count->count;
            }
        }




        $filteredResult = [];
        if ($showHombres) {
            $filteredResult['hombres'] = $result['hombres'];
        }
        if ($showMujeres) {
            $filteredResult['mujeres'] = $result['mujeres'];
        }

        return response()->json($filteredResult);
        return Excel::download(new GraficaExport($filteredResult), 'grafica.xlsx');
    }

    public function delete(Request $request)
    {
        $alumno = alumnos_model::find($request->id);
        if (!isset($alumno)) {
            alert()->error('Error', 'Alumno no encontrado');
            return redirect()->route('alumnos');
        }
        $alumno->delete();

        alert()->success('Exito', 'El alumno se elimino de forma correcta');
        return redirect()->route('alumnos');
    }
}
