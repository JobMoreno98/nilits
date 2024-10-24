<?php

namespace App\Http\Controllers;

use App\Models\alumno_tutorModel;
use App\Models\alumnos_model;
use App\Models\maestrosModel;
use App\Models\LLenadoComboBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\Service\Attribute\Required;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GraficaExport;


class alumnosContorller extends Controller
{
    public function index()
    {

        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        // Obtener las fechas de titulación únicas
        $fechasTitulacion = alumnos_model::select('fechaTitulacion')->distinct()->get();

        // Solo mostrar a los alumnos con tutor y aplicar paginación
        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor_nombre', 'maestros.Apellido as tutor_apellido')
            ->get();


        // Listar a los maestros para poder asignarlos al crear un registro
        $tutores = maestrosModel::all();




        return view('alumnos.index', compact('totalRegistros', 'tutores', 'totalEgresados', 'totalActivos', 'totalBajas', 'alumnos', 'fechasTitulacion'));
    }



    public function show(alumnos_model $alumno)
    {

        return view('alumnos.show', compact('alumno'));
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



    private function obtenerNombreEstado($procedencia)
    {
        $estados = [
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
            31 => 'Zacatecas'
        ];

        return $estados[$procedencia] ?? 'Desconocido';
    }



    //Mostrar alumnos sin tutor

    public function alumnos_sin_tutor()
    {
        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->whereNull('maestros.codigo')
            ->where('alumnos.estatus', '=', 1) // Filtrar por estatus igual a 1
            ->select('alumnos.*')
            ->toSql();

        dd($alumnos);

        $tutores = maestrosModel::all();

        return view('alumnos.alumnos_sin_tutor', compact('alumnos', 'tutores'));
    }

    public function detalles($codigo)
    {
        $alumno = alumnos_model::where('codigo', $codigo)->first(); // Obtener los detalles del alumno según su código

        return response()->json($alumno); // Devolver la vista parcial con los detalles del alumno
    }


    public function asignar_tutor(Request $request)
    {
        $request->validate([
            //'codigo' => 'required',
            //'nombre' => 'required',
            //'telefono' => 'required',
            //'sexo' => 'required',
            //'procedencia' => 'required',
            //'correo' => 'required',
            //'fechaNac' => 'required',
            //'dictamen' => 'required',
            //'estatus' => 'required',
            //'tutor' => 'required'
            // Agrega aquí el resto de las validaciones necesarias
        ]);


        $tutor_alumno = new alumno_tutorModel();
        $tutor_alumno->codigo = $request->codigo;
        $tutor_alumno->id_tutor = $request->tutor;
        $tutor_alumno->activo = 1;
        // Asigna el resto de los campos
        $tutor_alumno->save();
        //$alumno->update();

        return redirect()->back()->with('success', 'Alumno creado exitosamente');
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
        $tutor_alumno = new alumno_tutorModel();
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
    public function editar(Request $request, $codigo)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'calendarioTitulacion' => 'required',
            'ingreso' => 'required',
            'dictamen' => 'required',
        ]);
        // Obtener el alumno a actualizar
        $alumno = alumnos_model::where('codigo', 'like', "%" . $codigo)->first();

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
        alert()->success('Exito', 'Se edito de forma correcta al alumno');
        // Redireccionar o devolver una respuesta JSON según tu necesidad
        return redirect()->route('alumnos');
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
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
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
            alumno_tutorModel::create([
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

    public function sin_tutor()
    {
        $alumnos = alumnos_model::leftjoin('alumno_tutor', 'alumno_tutor.codigo', '=', 'alumnos.codigo')
            ->select('alumnos.Nombre as nombre', 'alumnos.codigo', 'alumno_tutor.id_tutor as tutor_actual')
            ->where('alumno_tutor.id_tutor', null)
            ->where('alumnos.estatus', 1)->groupBy('alumnos.codigo')
            ->toSql();

        return $alumnos;
    }
}
