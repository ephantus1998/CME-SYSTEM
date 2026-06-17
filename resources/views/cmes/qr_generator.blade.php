@extends('layouts.app')

@section('content')
<style>
    /* Clean CSS visibility utility specifically for physical printers */
    @media print {
        .no-print {
            display: none !important;
        }
        
        /* Ensure the main container card block fills up gracefully without being clipped */
        .card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin-top: 20px !important;
        }

        /* Force the browser to render the vector SVG paths perfectly black */
        svg {
            display: block !important;
            margin: 0 auto !important;
            max-width: 100% !important;
        }
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            
            <div class="card shadow p-4">
                <span class="text-uppercase text-muted fw-bold small no-print">Live QR Code Attacher</span>
                <h3 class="text-primary mt-1 mb-3">{{ $cme->title }}</h3>

                <form action="{{ route('cmes.qr.generator', $cme->id) }}" method="GET" class="row g-2 justify-content-center mb-4 no-print">
                    <div class="col-auto">
                        <label for="minutes" class="col-form-label fw-bold">Keep Active For:</label>
                    </div>
                    <div class="col-auto">
                        <select name="minutes" id="minutes" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="15" {{ $minutes == 15 ? 'selected' : '' }}>15 Minutes</option>
                            <option value="30" {{ $minutes == 30 ? 'selected' : '' }}>30 Minutes</option>
                            <option value="45" {{ $minutes == 45 ? 'selected' : '' }}>45 Minutes</option>
                            <option value="60" {{ $minutes == 60 ? 'selected' : '' }}>1 Hour</option>
                            <option value="120" {{ $minutes == 120 ? 'selected' : '' }}>2 Hours</option>
                            <option value="180" {{ $minutes == 180 ? 'selected' : '' }}>3 Hours</option>
                            <option value="240" {{ $minutes == 240 ? 'selected' : '' }}>4 Hours</option>
                            <option value="360" {{ $minutes == 360 ? 'selected' : '' }}>6 Hours</option>
                            <option value="480" {{ $minutes == 480 ? 'selected' : '' }}>8 Hours</option>
                            <option value="720" {{ $minutes == 720 ? 'selected' : '' }}>12 Hours</option>
                        </select>
                    </div>
                </form>

                <hr class="no-print">

                <div class="bg-white p-4 d-inline-block rounded shadow-sm my-3 border mx-auto">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($signedUrl) !!}
                </div>

                <p class="text-danger fw-bold mt-2">
                    <i class="bi bi-clock-history"></i> This QR code will automatically deactivate in 
                    @if($minutes >= 60)
                        {{ $minutes / 60 }} {{ \Illuminate\Support\Str::plural('Hour', $minutes / 60) }}.
                    @else
                        {{ $minutes }} Minutes.
                    @endif
                </p>
                
                <div class="d-flex gap-2 justify-content-center mt-3 no-print">
                    <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-printer-fill me-1"></i> Print QR Code
                    </button>
                    <a href="{{ route('cmes.index') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                </div>

                <div class="alert alert-light border small text-muted text-break mt-4 mb-0 no-print">
                    <strong>Target Link:</strong> <span class="user-select-all">{{ $signedUrl }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection