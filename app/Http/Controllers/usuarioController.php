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
            'nivel' => 0
        ]);

        return redirect()->route('/');
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
            'role' =>  'required',
            'nombre' => ['required', Rule::unique('usuario')->ignore($usuario->id)],
        ]);

        $roles = ['admin' => 1, 'maestro' => 2, 'apoyo tutorias' => 3, 'administrativo' => 4];
        $usuario->syncRoles(); # Se borran todos los anteriores
        $usuario->syncRoles([$request->role]);
        $usuario->nivel = $roles[$request->role];
        $usuario->update();

        return redirect()->route('usuarios.index');
    }
}
