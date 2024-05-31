<?php

namespace App\Http\Controllers;

use App\Models\alumno_tutorModel;
use App\Models\alumnos_model;
use App\Models\maestrosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\Service\Attribute\Required;

class alumnosContorller extends Controller
{
    public function index()
    {



        $totalRegistros = alumnos_model::count();
        $totalEgresados = alumnos_model::where('estatus', 3)->count();
        $totalActivos = alumnos_model::where('estatus', 1)->count();
        $totalBajas = alumnos_model::where('estatus', 4)->count();

        // Solo mostrar a los alumnos con tutor y aplicar paginación
        $alumnos = DB::table('alumnos')
            ->leftJoin('alumno_tutor', 'alumnos.codigo', '=', 'alumno_tutor.codigo')
            ->leftJoin('maestros', 'alumno_tutor.id_tutor', '=', 'maestros.codigo')
            ->select('alumnos.*', 'maestros.Nombre as tutor_nombre', 'maestros.Apellido as tutor_apellido')
            ->paginate(10);


        // Listar a los maestros para poder asignarlos al crear un registro
        $tutores = maestrosModel::all();

        return view('alumnos.index', compact('totalRegistros', 'tutores', 'totalEgresados', 'totalActivos', 'totalBajas', 'alumnos', 'fechaTitulacion'));
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


    public function asignar_tutor(Request $request)
    {
        $validatedData = $request->validate([
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
        //$alumno->codigo = $validatedData['codigo'];
        //$alumno->Nombre = $validatedData['nombre'];
        //$alumno->telefono = $validatedData['telefono'];
        //$alumno->correo = $validatedData['correo'];
        //$alumno->sexo = $validatedData['sexo'];
        //$alumno->procedencia = $validatedData['procedencia'];
        //$alumno->fechaNac = $validatedData['fechaNac'];
        //$alumno->dictamen = $validatedData['dictamen'];
        //$alumno->estatus = $validatedData['estatus'];
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
        $alumno->ingreso = ' ';
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

        return redirect()->back()->with('success', 'Alumno creado exitosamente');
    }



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

    public function buscarAll(Request $request)
    {
        $query = $request->input('query');

        // Realizar la consulta para buscar alumnos por nombre
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

        $tutores = maestrosModel::all();

        // Devolver la vista con los resultados de la búsqueda
        return view('alumnos.index', ['alumnos' => $alumnos, 'tutores' => $tutores, 'totalRegistros' => $totalRegistros, 'totalEgresados' => $totalEgresados, 'totalActivos' => $totalActivos, 'totalBajas' => $totalBajas]);
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
    public function obtenerDatosGrafica(Request $request)


    {       
    
        // Recibir los parámetros de la solicitud
        $showHombres = $request->query('hombres') === 'true';
        $showMujeres = $request->query('mujeres') === 'true';
        $tipoTitulacion = $request->query('tipoTitulacion');
        $tipoMateria = $request->query('materia');

        // Inicializar la consulta
        $query = DB::table('alumnos')
            ->select('sexo', DB::raw('COUNT(*) as count'))
            ->groupBy('sexo');

        // Filtrar por carrera si se proporciona en la solicitud
        if ($request->query('carrera')!== 'carrera') {
            $query->where('carrera', $request->query('carrera'));
        }

        if ($tipoTitulacion && $tipoTitulacion !== 'Tipo deTitulacion') {
            error_log($tipoTitulacion);
            $query->where('tipoTitulacion', $tipoTitulacion);
        }

        if ($tipoMateria && $tipoMateria !== 'materia') {
            error_log($tipoMateria);
            $query->where('materia', $tipoMateria);
        }



        // Ejecutar la consulta
        $counts = $query->get();

        // Inicializar los resultados
        $result = [
            'hombres' => 0,
            'mujeres' => 0,
        ];

        // Iterar sobre los resultados y asignar los conteos a las variables correspondientes
        foreach ($counts as $count) {
            if ($count->sexo == '0' && $showHombres) {
                $result['hombres'] = $count->count;
            } elseif ($count->sexo == '1' && $showMujeres) {
                $result['mujeres'] = $count->count;
            }
        }



        // Filtrar el resultado según los checkboxes seleccionados
        $filteredResult = [];
        if ($showHombres) {
            $filteredResult['hombres'] = $result['hombres'];
        }
        if ($showMujeres) {
            $filteredResult['mujeres'] = $result['mujeres'];
        }

        Log::info('Consulta ejecutada: ' . $query->toSql());
        Log::info('Parámetros: ', $query->getBindings());
        Log::info('Resultados: ', $result);

        // Devolver la respuesta en formato JSON
        return response()->json($filteredResult);
    }
    


}
