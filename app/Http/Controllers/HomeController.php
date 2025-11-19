<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Vacuna;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $titulo_pagina = 'Dashboard Veterinaria';
        
        // Estadísticas
        $total_clientes = Cliente::count();
        $total_citas = Cita::count();
        $total_consultas = Consulta::count();
        $total_vacunas = Vacuna::count();
        
        // Citas próximas (hoy y futuro)
        $citas_proximas = Cita::with('cliente')
            ->where('fecha', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->limit(5)
            ->get();

        return view('modules.home.home', compact(
            'titulo_pagina',
            'total_clientes',
            'total_citas',
            'total_consultas',
            'total_vacunas',
            'citas_proximas'
        ));
    }
}