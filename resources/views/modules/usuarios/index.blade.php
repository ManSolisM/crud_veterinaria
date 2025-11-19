@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
                <i class="bi bi-plus-circle"></i> Nuevo Usuario
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
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                        <tr class="{{ $usuario->trashed() ? 'table-secondary' : '' }}">
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->trashed())
                                    <span class="badge bg-danger">Eliminado</span>
                                @elseif($usuario->activo == 1)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-warning">Inactivo</span>
                                @endif
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
    @if($usuario->trashed())
        <form action="{{ route('usuarios.restore', $usuario->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-success" 
                    onclick="return confirm('¿Restaurar este usuario?')" 
                    title="Restaurar usuario">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </form>
    @else
        <button class="btn btn-sm btn-warning" 
                onclick="editarUsuario({{ $usuario }})" 
                title="Editar usuario">
            <i class="bi bi-pencil"></i>
        </button>
        
        <form action="{{ route('usuarios.toggle-activo', $usuario->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm {{ $usuario->activo == 1 ? 'btn-secondary' : 'btn-success' }}" 
                    title="{{ $usuario->activo == 1 ? 'Desactivar usuario' : 'Activar usuario' }}">
                <i class="bi {{ $usuario->activo == 1 ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
            </button>
        </form>
        
        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" 
                    onclick="return confirm('¿Eliminar este usuario?')" 
                    title="Eliminar usuario">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Nuevo Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
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

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarUsuario" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (dejar en blanco para no cambiar)</label>
                        <input type="password" name="password" class="form-control">
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
function editarUsuario(usuario) {
    document.getElementById('edit_name').value = usuario.name;
    document.getElementById('edit_email').value = usuario.email;
    document.getElementById('formEditarUsuario').action = `/usuarios/${usuario.id}`;
    new bootstrap.Modal(document.getElementById('modalEditarUsuario')).show();
}
</script>
@endsection