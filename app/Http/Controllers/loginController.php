<?php

namespace App\Http\Controllers;

use App\Models\ususario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    //


public function index(Request $request)
{
    $request->validate([
        'nombre' => ['required'],
        'pass' => ['required'],
    ]);

    $user = ususario::where('nombre', $request->nombre)->first();

    if ($user && hash('sha1', $request->pass) == $user->pass) {
        // Inicia la sesión manualmente
        Auth::login($user);
        $request->session()->regenerate();

        // Lógica de redirección basada en el nivel del usuario
        // ...
        // Redirigir basado en el nivel del usuario
        if ($user->nivel == 1) {
            // Si el usuario es administrador
            return redirect('/home'); // Asegúrate de que esta ruta exista
        } elseif ($user->nivel == 2) {
            // Si el usuario es un usuario normal
            return redirect('/tutor'); // Asegúrate de que esta ruta exista
        } else {
            // Si tiene un nivel diferente, redirigir a la página de inicio o a otra vista
            return redirect('/home'); // Ruta de fallback
        }
    } else {
        // Manejar la falla de autenticación
        return back()->withErrors([
            'nombre' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }
}

public function logout(Request $request){
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}

}
