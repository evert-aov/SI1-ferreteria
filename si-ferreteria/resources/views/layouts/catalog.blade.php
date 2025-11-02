<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Ferretería Nando</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            background: linear-gradient(135deg, #1a1f2e 0%, #0f1419 100%);
            min-height: 100vh;
            color: #e5e7eb;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #1f2937 0%, #111827 100%);
            border-bottom: 3px solid #f97316;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            color: #f97316 !important;
            font-weight: bold;
            font-size: 1.5rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .navbar-brand:hover {
            color: #fb923c !important;
            transform: scale(1.05);
        }

        .nav-link {
            color: #e5e7eb !important;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #f97316 !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            right: 0;
            height: 2px;
            background: #f97316;
        }

        .btn-dashboard {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            border: none;
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(249, 115, 22, 0.3);
        }

        .btn-dashboard:hover {
            background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(249, 115, 22, 0.4);
            color: white !important;
        }

        .btn-auth {
            background: transparent;
            border: 2px solid #f97316;
            color: #f97316 !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            background: #f97316;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(249, 115, 22, 0.3);
        }

        footer {
            background: linear-gradient(90deg, #1f2937 0%, #111827 100%);
            border-top: 2px solid #f97316;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.3);
        }

        .footer-brand {
            color: #f97316;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            @auth
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="bi bi-shop"></i> Ferretería Nando
                </a>
            @else
                <a class="navbar-brand" href="{{ route('products.index') }}">
                    <i class="bi bi-shop"></i> Ferretería Nando
                </a>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('catalog.index') }}">
                            <i class="bi bi-grid-3x3-gap"></i> Catálogo
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-dashboard btn-sm" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Ir al Panel
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-auth btn-sm" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="text-white mt-5 py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="footer-brand mb-2">
                        <i class="bi bi-shop"></i> Ferretería Nando
                    </h5>
                    <p class="text mb-0">Tu ferretería de confianza</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1" style="color: #9ca3af;">
                        <i class="bi bi-geo-alt"></i> Santa Cruz, Bolivia
                    </p>
                    <p class="mb-0 text">
                        &copy; {{ date('Y') }} Ferretería Nando. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
