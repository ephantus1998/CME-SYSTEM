@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('cmes.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Back to Sessions
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark text-white p-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Edit CME Session Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cmes.update', $cme->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">CME Topic / Title</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $cme->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label fw-bold">Scheduled Date</label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', $cme->date) }}" 
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label fw-bold">Venue Location</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       placeholder="e.g., Main Hall, Boardroom"
                                       value="{{ old('location', $cme->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="facilitator" class="form-label fw-bold">Facilitator / Speaker Name</label>
                            <input type="text" 
                                   class="form-control @error('facilitator') is-invalid @enderror" 
                                   id="facilitator" 
                                   name="facilitator" 
                                   value="{{ old('facilitator', $cme->facilitator) }}" 
                                   required>
                            @error('facilitator')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="text-muted">

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('cmes.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Save Updates
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection