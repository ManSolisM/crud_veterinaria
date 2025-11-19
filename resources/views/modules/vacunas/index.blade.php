@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaVacuna">
                <i class="bi bi-plus-circle"></i> Nueva Vacuna
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
                            <th>Cliente</th>
                            <th>Mascota</th>
                            <th>Tipo de Vacuna</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vacunas as $vacuna)
                        <tr>
                            <td>{{ $vacuna->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($vacuna->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $vacuna->cliente->nombre_completo }}</td>
                            <td>{{ $vacuna->cliente->nombre_mascota }}</td>
                            <td>{{ $vacuna->tipo_vacuna }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick='editarVacuna(@json($vacuna))'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('vacunas.destroy', $vacuna->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro de vacuna?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay vacunas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Vacuna -->
<div class="modal fade" id="modalNuevaVacuna" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-shield-fill-plus"></i> Nueva Vacuna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vacunas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
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
                        <label class="form-label">Tipo de Vacuna</label>
                        <input type="text" name="tipo_vacuna" class="form-control" required placeholder="Ej: Rabia, Parvovirus, Triple Felina">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Aplicación</label>
                        <input type="date" name="fecha" class="form-control" required>
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

<!-- Modal Editar Vacuna -->
<div class="modal fade" id="modalEditarVacuna" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Vacuna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarVacuna" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
                        <label class="form-label">Tipo de Vacuna</label>
                        <input type="text" name="tipo_vacuna" id="edit_tipo_vacuna" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Aplicación</label>
                        <input type="date" name="fecha" id="edit_fecha" class="form-control" required>
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
function editarVacuna(vacuna) {
    document.getElementById('edit_cliente_id').value = vacuna.cliente_id;
    document.getElementById('edit_tipo_vacuna').value = vacuna.tipo_vacuna;
    document.getElementById('edit_fecha').value = vacuna.fecha;
    document.getElementById('formEditarVacuna').action = `/vacunas/${vacuna.id}`;
    new bootstrap.Modal(document.getElementById('modalEditarVacuna')).show();
}
</script>
@endsection