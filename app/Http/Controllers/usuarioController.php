<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ususario;
use Spatie\Permission\Models\Role as ModelsRole;

class usuarioController extends Controller
{
    //
    public function registro(Request $request)
    {
        // Verificar si ya existe un usuario con el mismo nombre
        $usuarioExistente = ususario::where('nombre', $request->nombre)->first();

        if ($usuarioExistente) {
            // Si el usuario ya existe, redirigir con un mensaje de error
            return redirect()->back()->with('message', 'El nombre de usuario ya está en uso.')->withInput();
        } elseif ($request->pass == $request->pass2) {
            // Si no existe y las contraseñas coinciden, crear el usuario
            $usuario = new ususario();
            $usuario->nombre = $request->nombre;
            $usuario->pass = hash('sha1', $request->pass); // Usar Hash::make para encriptar la contraseña
            $usuario->nivel = 2;
            $usuario->save();

            return redirect()->route('/')->with('message', 'Usuario registrado con éxito.');
        } else {
            // Si las contraseñas no coinciden, redirigir con un mensaje de error

            return redirect()->back()->with('message', 'Las contraseñas no coinciden.')->withInput();
        }
    }

    public function index()
    {
        $usuarios = ususario::all();
        return view('usuarios.index', compact('usuarios'));
    }
    public function edit(ususario $usuario)
    {
        $roles = ModelsRole::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, ususario $usuario)
    {
        $request->validate([
            'role' => 'required',
            'nombre' => 'required'
        ]);
        $usuario->assignRole($request->role);

        return redirect()->route('usuarios.index');
    }
}
