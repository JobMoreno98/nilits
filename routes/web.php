<?php

use App\Http\Controllers\alumnosContorller;
use App\Http\Controllers\asesoresController;
use App\Http\Controllers\aspirantesController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\normatividadController;
use App\Http\Controllers\numeraliaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\tutorController;
use App\Http\Controllers\usuarioController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use illuminate\Support\Facades\Mail;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('usuarios', usuarioController::class)->middleware(['auth', isAdmin::class]);

Route::resource('permisos', PermisosController::class)->middleware(['auth', isAdmin::class])->except('create');

Route::resource("roles", RolesController::class)->middleware(['auth', isAdmin::class]);

Route::get("asignar-permisos/{id}", [
    "as" => "asignar_permisos",
    "uses" => "App\Http\Controllers\RolesController@relacionar",
])->middleware(['auth', isAdmin::class]);

Route::post("guardar-relacion-permisos", [
    "as" => "guardar_relacion_permisos",
    "uses" => "App\Http\Controllers\RolesController@guardarRelacion",
])->middleware(['auth', isAdmin::class]);;


//Rutas de iniciao
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('/home');
    } else {
        return view('welcome');
    }
})->name('/');

Route::post('login', [loginController::class, 'index'])->name('login');

Route::post('logout', [loginController::class, 'logout'])->name('logout');



Route::get('/home', function () {
    return view('home.index');
})->name('/home')->middleware(['auth', isAdmin::class]);


Route::get('alumnado', [alumnosContorller::class, 'alumnado_restringido'])->name('alumnado')->middleware(['auth']);

Route::get('alumnos', [alumnosContorller::class, 'index'])->name('alumnos')->middleware(['auth']);
Route::get('alumnos/{alumno}', [alumnosContorller::class, 'show'])->name('alumnos.show')->middleware(['auth']);

Route::delete('/elminarAsignado/{codigo}', [asesoresController::class, 'desasignar'])->name('elminarAsignado')->middleware(['auth']);


Route::get('alumnos/detalles/all/{codigo}', [alumnosContorller::class, 'detalles'])->name('alumnos/detalles/all')->middleware(['auth']);

Route::post('/alumnos/crear', [alumnosContorller::class, 'store'])->name('/alumnos/crear')->middleware(['auth']);

Route::post('registro', [usuarioController::class, 'registro'])->name('registro');

Route::post('/aplicaras', [alumnosContorller::class, 'asignacion'])->name('aplicaras')->middleware(['auth']);

//ruta para mostrar alumnos sin tutor
Route::get('/alumnos/sin-tutor', [alumnosContorller::class, 'alumnos_sin_tutor'])->name('/alumnos/sintutor')->middleware(['auth']);

Route::post('/alumnos/asingnar/', [alumnosContorller::class, 'asignar_tutor'])->name('/alumnos/asingnar/')->middleware(['auth']);

Route::get('/buscar-alumno', [alumnosContorller::class, 'buscar'])->name('buscarAlumno')->middleware(['auth']);

//Route::get('/buscar-alumno', [alumnosContorller::class,'buscar'])->name('buscarAlumno');



//Busqueda
/*
Route::get('/buscar-alumno/restricted', [alumnosContorller::class, 'buscarAllRestricted'])->name('/buscar-alumno/restricted')->middleware(['auth']);

Route::get('buscar-alumno/all', [alumnosContorller::class, 'buscarAll'])->name('buscarAlumno/all')->middleware(['auth']);


*/


//Ruta numeralia
Route::middleware('auth')->group(function () {
    Route::put('/alumnos/update/{codigo}', [alumnosContorller::class, 'update'])->name('/alumnos/update/')->middleware([isAdmin::class]);

    Route::get('numeralia', [numeraliaController::class, 'index'])->name('numeralia');

    Route::get('grafica', [alumnosContorller::class, 'obtenerDatosGrafica'])->name('grafica');

    Route::get('grafica-combo', [alumnosContorller::class, 'LlenadoComboBox'])->name('grafica-combo');

    Route::get('grafica-dictamen', [alumnosContorller::class, 'LlenadoComboBoxDictamen'])->name('grafica-dictamen');

    Route::get('grafica-estatus', [alumnosContorller::class, 'LlenadoComboBoxEstatus'])->name('grafica-estatus');

    Route::get('grafica-ciclo', [alumnosContorller::class, 'LlenadoComboBoxCiclo'])->name('grafica-ciclo');

    Route::get('grafica-ingreso', [alumnosContorller::class, 'LlenadoComboBoxIngreso'])->name('grafica-ingreso');

    Route::get('export-grafica', [alumnosContorller::class, 'exportGrafica'])->name('export-grafica');
    //Ruta normatividad

    Route::get('normatividad', [normatividadController::class, 'indexNo'])->name('normatividad');


    // Asesores

    Route::get('asesor/{asesor}', [asesoresController::class, 'show'])->middleware('auth')->name('asesor.show');

    Route::put('/asesor/{id}/delete', [asesoresController::class, 'delete'])->name('asesor.delete')->middleware([isAdmin::class]);

    Route::get('/alumnos-sin-tutor', [alumnosContorller::class, 'sin_tutor'])->name('alumnos.sin-tutor');


    //PDF controller
    Route::get('/generar-oficio-asignacion/{codigo}', [PDFController::class, 'oficioAsignacion'])->name('oficio.asignacion')->middleware([isAdmin::class]);

    Route::get('/generar-constancia-tutoria/{codigo}', [PDFController::class, 'constanciaTutoria'])->name('generar-constancia-tutoria')->middleware([isAdmin::class]);

    //Ruta para el manejo de los maestros
    Route::get('asesores', [asesoresController::class, 'index'])->name('asesores')->middleware(['auth']);

    Route::get('tutor', [tutorController::class, 'index'])->name('tutor')->middleware(['auth']);

    Route::get('gestionar-tutores', [asesoresController::class, 'getionarT'])->name('gestionar-tutores')->middleware(['auth']);

    Route::get('/maestros/tutorados/{maestroId}', [asesoresController::class, 'getTutorados'])->name('/maestros/tutorados/')->middleware(['auth']);

    Route::put('/maestros/update/{codigo}', [asesoresController::class, 'actualizarMaestro'])->name('/maestros/update/');

    Route::post('/maestros/store', [asesoresController::class, 'store'])->name('/maestros/store');

    Route::get('/aspirantes-admin', [aspirantesController::class, 'admin'])->name('aspirantes.admin');
});



// Route::get('/export', [alumnosContorller::class, 'export'])->name('export');

Route::get('/registro-usuarios', [usuarioController::class, 'registro_usuarios'])->name('registro-usuario');


//!Ruta aspirantes

Route::get('aspirante', [aspirantesController::class, 'index'])->name('aspirantes.index');

Route::post('/aspirante/crear', [aspirantesController::class, 'store'])->name('aspirantes.store');

Route::get('contactanos', function () {
    Mail::to('ezequielmora.chk@gmail.com')->send(new \App\Mail\ContactanosMailable);
    return "Mensaje enviado";
})->name('contactanos');






Route::post('/alumnos-asigandos/{id}', [asesoresController::class, 'alumnos_asigandos'])->name('asigandos-alumnos')->middleware(['auth', isAdmin::class]);

Route::post('/asignar-alumnos/{id}', [asesoresController::class, 'asignar_alumnos'])->name('asignar-alumnos')->middleware(['auth', isAdmin::class]);

Route::put('/eliminar-alumno/{id}', [alumnosContorller::class, 'delete'])->name('alumnos.delete')->middleware(['auth', isAdmin::class]);
