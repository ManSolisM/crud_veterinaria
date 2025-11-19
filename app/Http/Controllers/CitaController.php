<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $titulo_pagina = 'Gestión de Citas';
        $citas = Cita::with('cliente')->orderBy('fecha', 'desc')->orderBy('hora', 'desc')->get();
        $clientes = Cliente::orderBy('apellido_paterno', 'asc')->get();
        return view('modules.citas.index', compact('titulo_pagina', 'citas', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'cliente_id' => 'required|exists:clientes,id',
            'numero_telefonico' => 'required|string|max:15',
        ]);

        Cita::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string|max:500',
            'cliente_id' => 'required|exists:clientes,id',
            'numero_telefonico' => 'required|string|max:15',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}