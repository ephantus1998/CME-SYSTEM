@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Schedule New CME Session</h5>
                    <a href="{{ route('cmes.index') }}" class="btn btn-sm btn-outline-light">Back to List</a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cmes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">CME Topic / Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="e.g., Infection Control Protocols" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold">Session Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-content')) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="facilitator" class="form-label fw-bold">Facilitator / Speaker</label>
                            <input type="text" name="facilitator" id="facilitator" class="form-control" placeholder="e.g., Dr. John Smith" value="{{ old('facilitator') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-bold">Venue / Location</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="e.g., Main Seminar Hall" value="{{ old('location') }}">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">Create Session</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection