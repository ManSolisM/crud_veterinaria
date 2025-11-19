@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                <i class="bi bi-plus-circle"></i> Nuevo Cliente
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
                            <th>Dueño</th>
                            <th>Mascota</th>
                            <th>Especie</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ $cliente->nombre_mascota }}</td>
                            <td>{{ $cliente->especie }}</td>
                            <td>{{ $cliente->raza }}</td>
                            <td>{{ $cliente->edad_mascota }} años</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editarCliente({{ $cliente }})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cliente?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay clientes registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre(s) del Dueño</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                    <hr>
                    <h6 class="text-primary"><i class="bi bi-heart"></i> Información de la Mascota</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre de la Mascota</label>
                            <input type="text" name="nombre_mascota" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Especie</label>
                            <select name="especie" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Conejo">Conejo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Raza</label>
                            <input type="text" name="raza" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Edad (años)</label>
                            <input type="number" name="edad_mascota" class="form-control" min="0" required>
                        </div>
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

<!-- Modal Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarCliente" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" id="edit_apellido_paterno" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="apellido_materno" id="edit_apellido_materno" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre(s) del Dueño</label>
                        <input type="text" name="nombres" id="edit_nombres" class="form-control" required>
                    </div>
                    <hr>
                    <h6 class="text-warning"><i class="bi bi-heart"></i> Información de la Mascota</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre de la Mascota</label>
                            <input type="text" name="nombre_mascota" id="edit_nombre_mascota" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Especie</label>
                            <select name="especie" id="edit_especie" class="form-control" required>
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Conejo">Conejo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Raza</label>
                            <input type="text" name="raza" id="edit_raza" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Edad (años)</label>
                            <input type="number" name="edad_mascota" id="edit_edad_mascota" class="form-control" min="0" required>
                        </div>
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
function editarCliente(cliente) {
    document.getElementById('edit_apellido_paterno').value = cliente.apellido_paterno;
    document.getElementById('edit_apellido_materno').value = cliente.apellido_materno;
    document.getElementById('edit_nombres').value = cliente.nombres;
    document.getElementById('edit_nombre_mascota').value = cliente.nombre_mascota;
    document.getElementById('edit_especie').value = cliente.especie;
    document.getElementById('edit_raza').value = cliente.raza;
    document.getElementById('edit_edad_mascota').value = cliente.edad_mascota;
    document.getElementById('formEditarCliente').action = `/clientes/${cliente.id}`;
    new bootstrap.Modal(document.getElementById('modalEditarCliente')).show();
}
</script>
@endsection