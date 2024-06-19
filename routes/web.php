<?php

use App\Mail\ContactanosMailable;
use App\Http\Controllers\alumnosContorller;
use App\Http\Controllers\asesoresController;
use App\Http\Controllers\aspirantesController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\normatividadController;
use App\Http\Controllers\numeraliaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\tutorController;
use App\Http\Controllers\usuarioController;
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

//Rutas de iniciao
Route::get('/', function () {
    return view('welcome');
})->name('/');
Route::post('login',[loginController::class,'index'])->name('login');

Route::post('logout',[loginController::class,'logout'])->name('logout');



Route::get('/home', function(){
    return view('home.index');

})->name('/home');


Route::get('alumnado',[alumnosContorller::class, 'alumnado_restringido'])->name('alumnado');

Route::get('alumnos',[alumnosContorller::class,'index'])->name('alumnos');

Route::delete('/elminarAsignado/{codigo}',[asesoresController::class,'desasignar'])->name('elminarAsignado');


Route::get('alumnos/detalles/all/{codigo}',[alumnosContorller::class,'detalles'])->name('alumnos/detalles/all');

Route::post('/alumnos/crear', [alumnosContorller::class, 'store'])->name('/alumnos/crear');

Route::post('registro', [usuarioController::class, 'registro'])->name('registro');

Route::post('/aplicaras', [alumnosContorller::class, 'asignacion'])->name('aplicaras');

//ruta para mostrar alumnos sin tutor
Route::get('/alumnos/sintutor',[alumnosContorller::class,'alumno_sin_tutor'])->name('/alumnos/sintutor');

Route::post('/alumnos/asingnar/',[alumnosContorller::class,'asignar_tutor'])->name('/alumnos/asingnar/');

Route::get('/buscar-alumno', [alumnosContorller::class,'buscar'])->name('buscarAlumno');

//Route::get('/buscar-alumno', [alumnosContorller::class,'buscar'])->name('buscarAlumno');



//Busqueda

Route::get('/buscar-alumno/restricted', [alumnosContorller::class,'buscarAllRestricted'])->name('/buscar-alumno/restricted');

Route::get('buscar-alumno/all', [alumnosContorller::class,'buscarAll'])->name('buscarAlumno/all');

Route::put('/alumnos/update/{codigo}', [alumnosContorller::class,'editar'])->name('/alumnos/update/');


//Ruta para el manejo de los maestros

Route::get('asesores',[asesoresController::class,'index'])->name('asesores');

Route::get('tutor', [tutorController::class,'index'])->name('tutor');

Route::get('gestionar-tutores', [asesoresController::class,'getionarT'])->name('gestionar-tutores');

Route::get('/maestros/tutorados/{maestroId}', [asesoresController::class,'getTutorados'])->name('/maestros/tutorados/');

Route::put('/maestros/update/{codigo}', [asesoresController::class,'actualizarMaestro'])->name('/maestros/update/');

Route::post('/maestros/store',[asesoresController::class,'store'])->name('/maestros/store');

//PDF controller

Route::get('/generar-oficio-asignacion', [PDFController::class, 'oficioAsignacion'])->name('oficio.asignacion');
Route::get('/generar-constancia-tutoria', [PDFController::class, 'constanciaTutoria'])->name('generar-constancia-tutoria');


//Ruta numeralia

Route::get('numeralia', [numeraliaController::class,'index'])->name('numeralia');

Route::get('grafica', [alumnosContorller::class, 'obtenerDatosGrafica'])->name('grafica');

Route::get('grafica-combo', [alumnosContorller::class, 'LlenadoComboBox'])->name('grafica-combo');

Route::get('grafica-dictamen', [alumnosContorller::class, 'LlenadoComboBoxDictamen'])->name('grafica-dictamen');

Route::get('grafica-estatus', [alumnosContorller::class, 'LlenadoComboBoxEstatus'])->name('grafica-estatus');

Route::get('grafica-ciclo', [alumnosContorller::class, 'LlenadoComboBoxCiclo'])->name('grafica-ciclo');

// Route::get('/export', [alumnosContorller::class, 'export'])->name('export');



//!Ruta aspirantes

Route::get('aspirante', [aspirantesController::class,'index'])->name('aspirante');

Route::post('/aspirante/crear', [aspirantesController::class, 'store'])->name('aspirantes.store');

Route::get('contactanos', function(){

    Mail::to('ezequielmora.chk@gmail.com')->send(new \App\Mail\ContactanosMailable);
    return "Mensaje enviado";

})->name('contactanos');



//Ruta normatividad

Route::get('normatividad', [normatividadController::class,'indexNo'])->name('normatividad');