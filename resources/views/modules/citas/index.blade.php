@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCita">
                <i class="bi bi-plus-circle"></i> Nueva Cita
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Mascota</th>
                            <th>Motivo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>{{ $cita->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                            <td>{{ $cita->cliente->nombre_completo }}</td>
                            <td>{{ $cita->cliente->nombre_mascota }}</td>
                            <td>{{ $cita->motivo }}</td>
                            <td>{{ $cita->numero_telefonico }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='editarCita(@json($cita))'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta cita?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay citas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Cita -->
<div class="modal fade" id="modalNuevaCita" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-calendar-plus"></i> Nueva Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccionar cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nombre_completo }} - {{ $cliente->nombre_mascota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo de la Cita</label>
                        <textarea name="motivo" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número Telefónico</label>
                        <input type="text" name="numero_telefonico" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Cita -->
<div class="modal fade" id="modalEditarCita" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarCita" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" id="edit_hora" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" id="edit_cliente_id" class="form-control" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nombre_completo }} - {{ $cliente->nombre_mascota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo de la Cita</label>
                        <textarea name="motivo" id="edit_motivo" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número Telefónico</label>
                        <input type="text" name="numero_telefonico" id="edit_numero_telefonico" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editarCita(cita) {
    document.getElementById('edit_fecha').value = cita.fecha;
    document.getElementById('edit_hora').value = cita.hora;
    document.getElementById('edit_cliente_id').value = cita.cliente_id;
    document.getElementById('edit_motivo').value = cita.motivo;
    document.getElementById('edit_numero_telefonico').value = cita.numero_telefonico;
    document.getElementById('formEditarCita').action = `/citas/${cita.id}`;
    new bootstrap.Modal(document.getElementById('modalEditarCita')).show();
}
</script>
@endsection