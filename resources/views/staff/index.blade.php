@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h2 class="mb-0 fw-bold text-dark">Staff Directory & Tracking</h2>
                    <p class="text-muted mb-0 small">Manage institutional profiles and audit total accumulated continuous training history.</p>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('staff.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name, staff number, or department..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-dark px-4">Filter</button>
                        @if(request('search'))
                            <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Staff Member Name</th>
                            <th>Staff ID Number</th>
                            <th>Primary Department</th>
                            <th class="text-center">Attended Sessions</th>
                            <th class="text-end pe-4">Administration Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffMembers as $member)
                            <tr>
                                <td class="fw-bold ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-light text-secondary d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </div>
                                        <span class="text-dark">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td><code class="text-secondary fw-semibold">{{ $member->staff_no }}</code></td>
                                <td><span class="badge bg-light text-dark border px-2 py-1">{{ $member->department }}</span></td>
                                <td class="text-center fw-bold text-info fs-5">{{ $member->attendances_count }}</td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staff.show', $member->id) }}" class="btn btn-sm btn-outline-primary px-3" title="View Lifetime Training Summary">
                                            <i class="bi bi-eye me-1"></i> Audit Logs
                                        </a>
                                        <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-sm btn-outline-secondary" title="Fix Profile Typos">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 text-light"></i>
                                    <p class="mt-2 mb-0">No staff registry profiles found matching your filters.</p>
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