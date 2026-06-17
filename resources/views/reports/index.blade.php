@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h2>Hospital Administration Reports Dashboard</h2>
        <p class="text-muted">Overview of tracking logs and presentation export summaries.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow border-0 p-3">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 font-monospace">Total Sessions Tracked</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalCmes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow border-0 p-3">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 font-monospace">Registered Staff Base</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $totalStaff }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow border-0 p-3">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 font-monospace">Avg. Attendance / Session</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ $averageAttendance }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold">Generate Export Sheets</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Topic</th>
                            <th>Session Date</th>
                            <th>Facilitator</th>
                            <th class="text-center">Staff Count (Present)</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cmes as $item)
                            <tr>
                                <td class="fw-bold ps-4">{{ $item->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                                <td>{{ $item->facilitator }}</td>
                                <td class="text-center fw-bold text-success">{{ $item->present_count }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('reports.export.csv', $item->id) }}" class="btn btn-sm btn-dark shadow-sm">
                                        <i class="bi bi-download me-1"></i> Download Excel / CSV Sheet
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No operational session matrix sheets are logged.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection