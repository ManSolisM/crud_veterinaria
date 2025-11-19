<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo_pagina ?? 'Veterinaria' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/jpeg" href="{{ asset('img/L_JAMELZ.jpeg') }}">

   <style>
        :root {
            --primary-color: #ff1ad9;
            --primary-dark: #05077c;
            --secondary-color: #06b6d4;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-logo i {
            font-size: 2rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        .sidebar-logo-text h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .sidebar-logo-text small {
            font-size: 0.75rem;
            opacity: 0.9;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            height: calc(100vh - 180px);
            overflow-y: auto;
        }
        
        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.875rem 1.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
            font-size: 0.925rem;
        }
        
        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .nav-link.active {
            background-color: rgba(79, 70, 229, 0.15);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .nav-link i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        /* Created By Section */
        .created-by {
            margin-top: 0.75rem;
            padding: 0.875rem;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .created-by-content {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .created-by-content i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-top: 2px;
        }
        
        .created-by-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }
        
        .created-label {
            font-size: 0.7rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }
        
        .created-brand {
            font-size: 1.125rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
        }
        
        .created-tagline {
            font-size: 0.625rem;
            color: var(--text-light);
            line-height: 1.3;
            font-weight: 400;
            margin-top: 2px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        /* Navbar */
        .navbar-custom {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .user-badge i {
            font-size: 1.25rem;
        }
        
        /* Content Area */
        .content-area {
            padding: 2rem;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            border-radius: 16px 16px 0 0 !important;
        }
        
        /* Buttons */
        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 8px;
        }
        
        /* Tables */
        .table {
            margin: 0;
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }
        
        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .alert i {
            font-size: 1.25rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }
        
        /* Badges */
        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--border-color);
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }
        
        .modal-title {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 0.625rem 1rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-area {
                padding: 1rem;
            }
            
            .navbar-custom {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    
    @yield('styles')
</head>
<body>
    @auth
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-logo">
                <i class="bi bi-heart-pulse-fill"></i>
                <div class="sidebar-logo-text">
                    <h4>VetSystem</h4>
                    <small>Gestión Veterinaria</small>
                </div>
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>Usuarios</span>
            </a>
            <a class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}" href="{{ route('citas.index') }}">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Citas</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" class="mb-2">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>
            </form>
            <div class="created-by">
                <div class="created-by-content">
                    <i class="bi bi-code-slash"></i>
                    <div class="created-by-text">
                        <span class="created-label">Creado por</span>
                        <span class="created-brand">JAMELZ</span>
                        <span class="created-tagline">Joint Architecture for Modern Engineering & Logical Zystems</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="navbar-custom">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title">{{ $titulo_pagina }}</h2>
                <div class="user-badge">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>