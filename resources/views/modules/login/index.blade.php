@extends('layouts.main')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center" style="background: linear-gradient(110deg, #ff1ad9 0%, #05077c 95%);">
            <div class="text-center text-white p-5">

                <!-- Imagen de animal veterinario -->
                <div class="mt-4">
                    <img src="{{ asset('img/animal2.png') }}" 
                        alt="Veterinaria Animal"
                        class="img-fluid"
                        style="max-width: 320px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3));">
                </div>

                <h1 class="mt-4 mb-3">Sistema Veterinario</h1>
                <p class="lead">Gestiona citas, clientes, consultas y vacunas de manera eficiente</p>
            </div>
        </div>
        
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="w-100" style="max-width: 400px;">

                {{-- IMAGEN de logo --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo_JA.png') }}" 
                        alt="Logo Veterinaria" 
                        class="img-fluid"
                        style="max-width: 200px;">
         
                        <h2 class="mt-3">Iniciar Sesión</h2>
                        <p class="text-muted">Ingresa tus credenciales para continuar</p>
                </div>


                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email Usuario
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="ejemplo@correo.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Ingresa tu contraseña">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Sistema seguro y protegido
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        overflow: hidden;
    }
</style>
@endsection