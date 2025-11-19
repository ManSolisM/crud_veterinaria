<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        $titulo_pagina = 'Inicio Sesión de Usuario';
        return view('modules.login.index', compact('titulo_pagina'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Verificar si el usuario está activo
            if (Auth::user()->activo != 1) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta ha sido desactivada.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function crearAdmin()
    {
        // Verificar si ya existe un admin
        $adminExists = User::where('email', 'admin@veterinaria.com')->exists();
        
        if ($adminExists) {
            return redirect()->route('login')->with('error', 'El usuario administrador ya existe.');
        }

        User::create([
            'name' => 'Administrador Solis',
            'email' => 'adminM2468@admin.com',
            'password' => Hash::make('LTz:RyTaeyf26Pn.'),
            'activo' => 1,
        ]);

        return redirect()->route('login')->with('success', 'Usuario administrador creado exitosamente. Email: admin@veterinaria.com | Password: admin123');
    }
}