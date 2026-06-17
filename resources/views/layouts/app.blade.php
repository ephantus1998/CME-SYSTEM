<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'CME Attendance Portal') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            /* FIXED LAYER ORDER: Mask first, image second, fallback color at the very end */
            background: linear-gradient(rgba(248, 249, 250, 0.88), rgba(248, 249, 250, 0.88)), 
                        url("{{ asset('images/background_1.jpeg') }}") no-repeat center center fixed #343a40;
            background-size: cover;
            min-height: 100vh;
        }

        .custom-navbar-logo {
            height: 45px !important;
            max-width: 140px !important;
            object-fit: contain !important;
        }

        .navbar-brand {
            max-width: 350px;
        }

        /* Modern subtle card styling to overlay clean data over the background asset */
        .glass-card {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(222, 226, 230, 0.7);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4 py-3">
        <div class="container-fluid container-xl">
            
            <a class="navbar-brand d-flex align-items-center gap-2 m-0 p-0" href="{{ Auth::guard('admins')->check() ? route('cmes.index') : route('staff.register') }}">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="AIC Kijabe Logo" 
                     class="custom-navbar-logo rounded-1 bg-white p-1">
                
                <div class="d-flex flex-column lh-sm ms-1">
                    <span class="fw-bold fs-5 text-white tracking-wide text-nowrap">AIC Kijabe Hospital</span>
                    <small class="text-info fw-semibold text-nowrap" style="font-size: 0.72rem; letter-spacing: 0.3px;">Naivasha Clinic — CME Portal</small>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-lg-center flex-wrap gap-3 mt-3 mt-lg-0">
                    
                    @if(Auth::guard('admins')->check())
                        <li class="nav-item">
                            <a class="nav-link text-nowrap d-flex align-items-center gap-1 {{ Request::is('cmes*') ? 'active fw-bold text-white' : '' }}" href="{{ route('cmes.index') }}">
                                <i class="bi bi-calendar3"></i> CME Sessions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-nowrap d-flex align-items-center gap-1 {{ Request::is('staff*') && !Request::is('staff/register') ? 'active fw-bold text-white' : '' }}" href="{{ route('staff.index') }}">
                                <i class="bi bi-person-badge"></i> Staff Directory
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link text-nowrap d-flex align-items-center gap-1 {{ Request::is('register-staff') || Request::is('staff/register') ? 'active fw-bold text-white' : '' }}" href="{{ route('staff.register') }}">
                            <i class="bi bi-person-plus"></i> Quick Sign-In
                        </a>
                    </li>

                    @if(Auth::guard('admins')->check())
                        <li class="nav-item">
                            <a class="nav-link text-nowrap d-flex align-items-center gap-1 fw-bold text-info {{ Request::is('reports*') ? 'text-white bg-info rounded px-2 py-1' : '' }}" href="{{ route('reports.index') }}">
                                <i class="bi bi-bar-chart-line-fill"></i> Reports
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-1 fw-bold text-nowrap d-flex align-items-center gap-1">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-light px-3 py-1 text-nowrap d-flex align-items-center gap-1 {{ Request::is('login') ? 'active d-none' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-shield-lock"></i> Admin Login
                            </a>
                        </li>
                    @endif

                </ul>
            </div>

        </div>
    </nav>

    <main class="pb-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>