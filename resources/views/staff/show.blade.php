@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ route('staff.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Directory
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow border-0 text-center p-4">
                <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle mx-auto my-3 shadow-sm" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-badge fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $staff->name }}</h4>
                <p class="text-muted small mb-3">Department: <strong>{{ $staff->department }}</strong></p>
                
                <hr class="text-muted">
                
                <div class="row text-center mt-2">
                    <div class="col-6 border-end">
                        <small class="text-uppercase text-muted opacity-75 fw-bold" style="font-size:0.7rem">Staff Number</small>
                        <div class="fw-bold text-secondary mt-1">{{ $staff->staff_no }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-uppercase text-muted opacity-75 fw-bold" style="font-size:0.7rem">Total CMEs</small>
                        <div class="fw-bold text-primary mt-1 fs-5">{{ $staff->attendances->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Lifetime Training Attendance Log</h5>
                </div>
                <div class="card-body p-4">
                    @if($staff->attendances->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 text-light"></i>
                            <p class="mt-2 mb-0">This staff member hasn't checked into any CME training sessions yet.</p>
                        </div>
                    @else
                        <div class="position-relative border-start border-2 border-light ps-4 ms-2">
                            @foreach($staff->attendances as $attendance)
                                <div class="mb-4 position-relative">
                                    <div class="position-absolute bg-success rounded-circle border border-4 border-white shadow-sm" style="width: 16px; height: 16px; left: -33px; top: 4px;"></div>
                                    
                                    <div class="card border border-light shadow-sm bg-white p-3">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                            <div>
                                                <h6 class="fw-bold mb-1 text-dark">{{ $attendance->cme->title }}</h6>
                                                <p class="mb-0 text-muted small">
                                                    <i class="bi bi-person-video3 me-1"></i> Facilitator: {{ $attendance->cme->facilitator }} 
                                                    <span class="mx-2">|</span> 
                                                    <i class="bi bi-geo-alt me-1"></i> Venue: {{ $attendance->cme->location ?? 'Main Hall' }}
                                                </p>
                                            </div>
                                            <span class="badge bg-secondary px-2 py-1">
                                                {{ \Carbon\Carbon::parse($attendance->cme->date)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection