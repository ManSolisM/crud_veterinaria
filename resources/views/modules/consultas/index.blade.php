@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaConsulta">
                <i class="bi bi-plus-circle"></i> Nueva Consulta
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
                            <th>Diagnóstico</th>
                            <th>Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->id }}</td>
                            <td>{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $consulta->cliente->nombre_completo }}</td>
                            <td>{{ $consulta->cliente->nombre_mascota }}</td>
                            <td>{{ Str::limit($consulta->diagnostico, 50) }}</td>
                            <td>${{ number_format($consulta->pago, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick='verConsulta(@json($consulta))'>
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick='editarConsulta(@json($consulta))'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta consulta?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay consultas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Consulta -->
<div class="modal fade" id="modalNuevaConsulta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-clipboard2-pulse"></i> Nueva Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('consultas.store') }}" method="POST">
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
                        <label class="form-label">Diagnóstico</label>
                        <textarea name="diagnostico" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pago</label>
                        <input type="number" name="pago" class="form-control" step="0.01" min="0" required>
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

<!-- Modal Ver Consulta -->
<div class="modal fade" id="modalVerConsulta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-eye"></i> Detalle de Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong>
                        <p id="ver_cliente"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Pago:</strong>
                        <p id="ver_pago"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Diagnóstico:</strong>
                    <p id="ver_diagnostico" class="border p-3 rounded"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Consulta -->
<div class="modal fade" id="modalEditarConsulta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarConsulta" method="POST">
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
                        <label class="form-label">Diagnóstico</label>
                        <textarea name="diagnostico" id="edit_diagnostico" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pago</label>
                        <input type="number" name="pago" id="edit_pago" class="form-control" step="0.01" min="0" required>
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
function verConsulta(consulta) {
    document.getElementById('ver_cliente').textContent = consulta.cliente.apellido_paterno + ' ' + consulta.cliente.apellido_materno + ' ' + consulta.cliente.nombres;
    document.getElementById('ver_diagnostico').textContent = consulta.diagnostico;
    document.getElementById('ver_pago').textContent = '$' + parseFloat(consulta.pago).toFixed(2);
    new bootstrap.Modal(document.getElementById('modalVerConsulta')).show();
}

function editarConsulta(consulta) {
    document.getElementById('edit_cliente_id').value = consulta.cliente_id;
    document.getElementById('edit_diagnostico').value = consulta.diagnostico;
    document.getElementById('edit_pago').value = consulta.pago;
    document.getElementById('formEditarConsulta').action = `/consultas/${consulta.id}`;
    new bootstrap.Modal(document.getElementById('modalEditarConsulta')).show();
}
</script>
@endsection