<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $titulo_pagina = 'Administración de Usuarios';
        $usuarios = User::withTrashed()->orderBy('created_at', 'desc')->get();
        return view('modules.usuarios.index', compact('titulo_pagina', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activo' => 1,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $usuario = User::withTrashed()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function restore($id)
    {
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado exitosamente.');
    }

    public function toggleActivo($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->activo = $usuario->activo == 1 ? 0 : 1;
        $usuario->save();

        $estado = $usuario->activo == 1 ? 'activado' : 'desactivado';
        return redirect()->route('usuarios.index')->with('success', "Usuario {$estado} exitosamente.");
    }
}