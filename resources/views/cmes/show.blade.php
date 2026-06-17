@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="text-uppercase text-muted fw-bold small">Session Auditing</span>
            <h2 class="text-primary mb-0">{{ $cme->title }}</h2>
        </div>
        <div>
            <a href="{{ route('cmes.qr.generator', $cme->id) }}" class="btn btn-dark shadow-sm">
                <i class="bi bi-qr-code me-1"></i> View/Print QR Code
            </a>
            <a href="{{ route('cmes.index') }}" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white p-4 text-center mb-4">
                <h6 class="text-uppercase opacity-75 fw-bold">Total Checked In</h6>
                <div class="display-1 fw-bold my-2">{{ $totalAttendance }}</div>
                <p class="mb-0 small"><i class="bi bi-person-check-fill me-1"></i> Registered Staff Members Present</p>
            </div>

            <div class="card shadow-sm p-4">
                <h5 class="card-title fw-bold mb-3 text-secondary">Turnout by Department</h5>
                
                @if($departmentMetrics->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-bar-chart fs-2"></i>
                        <p class="mt-2 small mb-0">Waiting for first scan data...</p>
                    </div>
                @else
                    @foreach($departmentMetrics as $department => $count)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span>{{ $department }}</span>
                                <span class="text-primary">{{ $count }} ({{ round(($count / $totalAttendance) * 100) }}%)</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ ($count / $totalAttendance) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-bold text-secondary mb-0">Live Attendance Log</h5>
                    <span class="badge bg-light text-dark border p-2">Session Date: {{ $cme->date }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Staff Name</th>
                                <th>Staff No</th>
                                <th>Department</th>
                                <th>Time Checked In</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cme->attendances as $attendance)
                                <tr>
                                    <td class="fw-bold">{{ $attendance->staff->name }}</td>
                                    <td><code>{{ $attendance->staff->staff_no }}</code></td>
                                    <td>{{ $attendance->staff->department }}</td>
                                    <td class="text-muted small">
                                        {{ $attendance->created_at->format('h:i A') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            Present
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 text-light"></i>
                                        <p class="mt-2 mb-0">No attendance registered yet for this session.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection