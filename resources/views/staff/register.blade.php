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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Staff Self-Registration Form</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g., Jane Doe" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="staff_no" class="form-label fw-bold">Staff / Employee Number</label>
                            <input type="text" name="staff_no" id="staff_no" class="form-control" placeholder="e.g., NUR-1234" value="{{ old('staff_no') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="department" class="form-label fw-bold">Department</label>
                            <select name="department" id="department" class="form-select" required>
                                <option value="" selected disabled>-- Select Department --</option>
                                <option value="Nursing" {{ old('department') == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                                <option value="Pharmacy" {{ old('department') == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                <option value="Laboratory" {{ old('department') == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                                <option value="Clinical Medicine" {{ old('department') == 'Clinical Medicine' ? 'selected' : '' }}>Clinical Medicine</option>
                                <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">Complete Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection