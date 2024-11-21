<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ususario;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class usuarioController extends Controller
{
    //
    public function registro_usuarios()
    {
        return view('registro');
    }
    public function registro(Request $request)
    {
        $request->validate([
            'nombre' =>  ['required', Rule::unique('usuario')],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        // Si no existe y las contraseñas coinciden, crear el usuario

        $usuario = ususario::create([
            'nombre' => $request->nombre,
            'pass' =>  sha1($request->password),
            'nivel' => 2
        ]);

        return $usuario;
        // Si las contraseñas no coinciden, redirigir con un mensaje de error


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
