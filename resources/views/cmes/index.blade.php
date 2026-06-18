@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Continuing Medical Education (CME)</h2>
            <p class="text-muted mb-0">Manage, track, and monitor clinical training sessions for the Naivasha Clinic.</p>
        </div>
        <a href="{{ route('cmes.create') }}" class="btn btn-primary btn-lg shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Create New Session
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold small tracking-wider">Total Scheduled Sessions</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $cmes->count() }}</h3>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-3 fs-3 line-height-1">
                        <i class="bi bi-calendar4-event"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold small tracking-wider">Total Attendance Logs</span>
                        <h3 class="fw-bold text-success mt-1 mb-0">{{ $cmes->sum('attendances_count') }}</h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-3 fs-3 line-height-1">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold small tracking-wider">Latest Facilitator</span>
                        <h3 class="fw-bold text-secondary mt-1 mb-0 text-truncate" style="max-width: 220px;">
                            {{ $cmes->first()->facilitator ?? 'None Scheduled' }}
                        </h3>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-3 fs-3 line-height-1">
                        <i class="bi bi-person-badge"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 tracking-wider fw-bold">Topic / Title</th>
                            <th class="py-3 text-uppercase fs-7 tracking-wider fw-bold">Date</th>
                            <th class="py-3 text-uppercase fs-7 tracking-wider fw-bold">Facilitator</th>
                            <th class="py-3 text-uppercase fs-7 tracking-wider fw-bold">Location</th>
                            <th class="py-3 text-uppercase fs-7 tracking-wider fw-bold text-center">Attended Staff</th>
                            <th class="pe-4 py-3 text-uppercase fs-7 tracking-wider fw-bold text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @forelse($cmes as $cme)
                            <tr style="transition: background-color 0.2s ease;">
                                <td class="ps-4 py-3 fw-semibold text-dark fs-6">{{ $cme->title }}</td>
                                <td class="py-3 text-secondary">{{ \Carbon\Carbon::parse($cme->date)->format('M d, Y') }}</td>
                                <td class="py-3 text-dark fw-medium">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-person text-muted"></i> {{ $cme->facilitator }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill fw-medium fs-7">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $cme->location ?? 'Main Hospital' }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge {{ $cme->attendances_count > 0 ? 'bg-success-subtle text-success' : 'bg-light text-muted border' }} px-3 py-2 fs-6 rounded-3 fw-bold">
                                        {{ $cme->attendances_count }}
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-inline-flex gap-1.5">
                                        <a href="{{ route('cmes.show', $cme->id) }}" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1 px-2.5 py-1.5 rounded-3">
                                            <i class="bi bi-bar-chart-line-fill"></i> Stats
                                        </a>
                                        <a href="{{ route('cmes.qr.generator', $cme->id) }}" class="btn btn-sm btn-dark d-flex align-items-center gap-1 px-2.5 py-1.5 rounded-3">
                                            <i class="bi bi-qr-code"></i> QR Code
                                        </a>
                                        <a href="{{ route('cmes.edit', $cme->id) }}" class="btn btn-sm btn-light border d-flex align-items-center p-2 rounded-3 text-primary" title="Edit Session">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('cmes.destroy', $cme->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this CME session and all its attendance records?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border d-flex align-items-center p-2 rounded-3 text-danger" title="Delete Session">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                    No CME sessions found. Click "Create New Session" to begin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-7 { font-size: 0.8rem; }
    .gap-1.5 { gap: 0.375rem; }
    .tracking-wider { tracking-spacing: 0.05em; }
    .line-height-1 { line-height: 1; }
</style>
@endsection