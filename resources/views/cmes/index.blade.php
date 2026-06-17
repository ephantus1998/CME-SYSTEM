@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Continuing Medical Education (CME) Sessions</h2>
        <a href="{{ route('cmes.create') }}" class="btn btn-primary shadow-sm">+ Create New Session</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm border-info" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill fs-5 me-2 text-info"></i>
                <div>{{ session('info') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Topic / Title</th>
                            <th>Date</th>
                            <th>Facilitator</th>
                            <th>Location</th>
                            <th class="text-center">Attended Staff</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cmes as $cme)
                            <tr>
                                <td class="fw-bold ps-4 text-dark">{{ $cme->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($cme->date)->format('M d, Y') }}</td>
                                <td>{{ $cme->facilitator }}</td>
                                <td><span class="badge bg-secondary">{{ $cme->location ?? 'Main Hall' }}</span></td>
                                <td class="text-center fw-bold text-primary fs-5">{{ $cme->attendances_count }}</td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('cmes.show', $cme->id) }}" class="btn btn-sm btn-info text-white fw-bold px-3" title="View Live Attendance Counter">
                                            <i class="bi bi-graph-up-inner me-1"></i> Live Stats
                                        </a>

                                        <a href="{{ route('cmes.qr.generator', $cme->id) }}" class="btn btn-sm btn-dark px-3" title="Project Dynamic QR Code">
                                            <i class="bi bi-qr-code me-1"></i> QR Code
                                        </a>

                                        <a href="{{ route('cmes.edit', $cme->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Session Details">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('cmes.destroy', $cme->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this CME session and its entire history?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-0 rounded-end" title="Delete Session">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 text-light"></i>
                                    <p class="mt-2 mb-0">No CME sessions found. Click "+ Create New Session" to get started!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection