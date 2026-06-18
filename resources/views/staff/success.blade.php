@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card shadow glass-card p-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                </div>
                
                <h2 class="fw-bold text-success mb-3">Registration Successful!</h2>
                <p class="text-muted fs-5 mb-4">
                    Thank you. Your details have been successfully captured for this CME session.
                </p>

                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <strong>Note:</strong> You can safely close this browser window or tab now.
                </div>

                <div class="d-grid gap-2">
                    <button onclick="window.close();" class="btn btn-outline-secondary btn-lg">Exit Window</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection