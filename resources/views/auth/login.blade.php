<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIC Kijabe — CME Administration Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="AIC Kijabe Logo" height="65" class="mb-2 rounded shadow-sm">
                <h4 class="fw-bold text-dark mb-1">AIC Kijabe Hospital</h4>
                <small class="text-muted fw-semibold uppercase tracking-wider">Naivasha Clinic — CME Administrative Gateway</small>
            </div>

            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-secondary text-center"><i class="bi bi-shield-lock-fill me-2"></i>Secure Sign-In</h5>
                    <hr class="text-muted mb-4">

                    @if(session('info'))
                        <div class="alert alert-info py-2 small shadow-sm"><i class="bi bi-info-circle me-1"></i> {{ session('info') }}</div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold text-secondary">Administrative Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Enter username" required autofocus>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold text-secondary">Security Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">Remember this workstation</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            Access Control Dashboard <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('staff.register') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-qr-code-scan me-1"></i> Shift to Public Staff Check-In Screen
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>