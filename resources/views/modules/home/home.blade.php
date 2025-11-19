@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Clientes</h6>
                            {{-- <h2 class="card-title mb-0">{{ $total_clientes }}</h2> --}}
                        </div>
                        <i class="bi bi-person-badge" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Citas</h6>
                            {{-- <h2 class="card-title mb-0">{{ $total_citas }}</h2> --}}
                        </div>
                        <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Consultas</h6>
                            {{-- <h2 class="card-title mb-0">{{ $total_consultas }}</h2> --}}
                        </div>
                        <i class="bi bi-clipboard2-pulse" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Vacunas</h6>
                            {{-- <h2 class="card-title mb-0">{{ $total_vacunas }}</h2> --}}
                        </div>
                        <i class="bi bi-shield-fill-plus" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Citas Próximas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Próximas Citas</h5>
                </div>
                <div class="card-body">
                    @if($citas_proximas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Cliente</th>
                                        <th>Mascota</th>
                                        <th>Motivo</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas_proximas as $cita)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                        <td>{{ $cita->cliente->nombre_completo }}</td>
                                        <td>{{ $cita->cliente->nombre_mascota }}</td>
                                        <td>{{ $cita->motivo }}</td>
                                        <td><i class="bi bi-telephone"></i> {{ $cita->numero_telefonico }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3">No hay citas programadas próximamente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection