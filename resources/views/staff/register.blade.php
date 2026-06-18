@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow glass-card">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Staff Self-Registration Form</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="e.g., Jane Doe" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span class="text-muted fw-normal">(Optional)</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="e.g., jdoe@kijabehospital.org" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="staff_no" class="form-label fw-bold">Staff / Employee Number</label>
                                <input type="text" name="staff_no" id="staff_no" class="form-control" placeholder="e.g., NUR-1234" value="{{ old('staff_no') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="license_no" class="form-label fw-bold">Council License Number <span class="text-muted fw-normal">(Optional)</span></label>
                                <input type="text" name="license_no" id="license_no" class="form-control" placeholder="e.g., KMPDC-XXXX / NCK-XXXX" value="{{ old('license_no') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="cadre" class="form-label fw-bold">Professional Cadre</label>
                                <select name="cadre" id="cadre" class="form-select" required>
                                    <option value="" selected disabled>-- Select Cadre --</option>
                                    <option value="Consultant" {{ old('cadre') == 'Consultant' ? 'selected' : '' }}>Consultant / Specialist</option>
                                    <option value="Medical Officer" {{ old('cadre') == 'Medical Officer' ? 'selected' : '' }}>Medical Officer</option>
                                    <option value="Clinical Officer" {{ old('cadre') == 'Clinical Officer' ? 'selected' : '' }}>Clinical Officer</option>
                                    <option value="Nursing Officer" {{ old('cadre') == 'Nursing Officer' ? 'selected' : '' }}>Nursing Officer</option>
                                    <option value="Pharmacist" {{ old('cadre') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist / Pharm Tech</option>
                                    <option value="Laboratory Scientist" {{ old('cadre') == 'Laboratory Scientist' ? 'selected' : '' }}>Laboratory Scientist / Tech</option>
                                    <option value="Medical Intern" {{ old('cadre') == 'Medical Intern' ? 'selected' : '' }}>Medical / Clinical / Nursing Intern</option>
                                    <option value="Administrative Staff" {{ old('cadre') == 'Administrative Staff' ? 'selected' : '' }}>Administrative Support</option>
                                    <option value="Allied Health Provider" {{ old('cadre') == 'Allied Health Provider' ? 'selected' : '' }}>Allied Health Provider</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="department" class="form-label fw-bold">Department</label>
                                <select name="department" id="department" class="form-select" required>
                                    <option value="" selected disabled>-- Select Department --</option>
                                    <optgroup label="Clinical & Medical">
                                        <option value="Internal Medicine" {{ old('department') == 'Internal Medicine' ? 'selected' : '' }}>Internal Medicine</option>
                                        <option value="General Surgery" {{ old('department') == 'General Surgery' ? 'selected' : '' }}>General Surgery</option>
                                        <option value="Pediatrics" {{ old('department') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics & Child Health</option>
                                        <option value="Obstetrics & Gynecology" {{ old('department') == 'Obstetrics & Gynecology' ? 'selected' : '' }}>Obstetrics & Gynecology (OB/GYN)</option>
                                        <option value="Emergency Medicine" {{ old('department') == 'Emergency Medicine' ? 'selected' : '' }}>Emergency Medicine / Casualty</option>
                                        <option value="Orthopedics" {{ old('department') == 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                        <option value="Anesthesia & Critical Care" {{ old('department') == 'Anesthesia & Critical Care' ? 'selected' : '' }}>Anesthesia & Critical Care (ICU/HDU)</option>
                                        <option value="Ophthalmology" {{ old('department') == 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology (Eye Clinic)</option>
                                        <option value="Dental" {{ old('department') == 'Dental' ? 'selected' : '' }}>Dental / Oral Health</option>
                                        <option value="OPD" {{ old('department') == 'OPD' ? 'selected' : '' }}>Outpatient Department (OPD)</option>
                                    </optgroup>
                                    <optgroup label="Clinical Support & Allied Health">
                                        <option value="Nursing" {{ old('department') == 'Nursing' ? 'selected' : '' }}>Nursing</option>
                                        <option value="Pharmacy" {{ old('department') == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                        <option value="Laboratory" {{ old('department') == 'Laboratory' ? 'selected' : '' }}>Laboratory & Pathology</option>
                                        <option value="Radiology" {{ old('department') == 'Radiology' ? 'selected' : '' }}>Radiology & Imaging</option>
                                        <option value="Physiotherapy" {{ old('department') == 'Physiotherapy' ? 'selected' : '' }}>Physiotherapy & Rehab</option>
                                        <option value="Nutrition" {{ old('department') == 'Nutrition' ? 'selected' : '' }}>Nutrition & Dietetics</option>
                                        <option value="Health Records" {{ old('department') == 'Health Records' ? 'selected' : '' }}>Health Records (HRIO)</option>
                                        <option value="Social Work" {{ old('department') == 'Social Work' ? 'selected' : '' }}>Medical Social Work / Counseling</option>
                                    </optgroup>
                                    <optgroup label="Administration & Corporate">
                                        <option value="ICT" {{ old('department') == 'ICT' ? 'selected' : '' }}>Information Communication Technology (ICT)</option>
                                        <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance & Accounts</option>
                                        <option value="Human Resources" {{ old('department') == 'Human Resources' ? 'selected' : '' }}>Human Resources (HR)</option>
                                        <option value="Procurement" {{ old('department') == 'Procurement' ? 'selected' : '' }}>Procurement & Supply Chain</option>
                                        <option value="Customer Care" {{ old('department') == 'Customer Care' ? 'selected' : '' }}>Customer Care & Reception</option>
                                        <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Hospital Administration</option>
                                        <option value="Chaplaincy" {{ old('department') == 'Chaplaincy' ? 'selected' : '' }}>Chaplaincy & Spiritual Care</option>
                                    </optgroup>
                                    <optgroup label="Operations & Support">
                                        <option value="Biomedical Engineering" {{ old('department') == 'Biomedical Engineering' ? 'selected' : '' }}>Biomedical Engineering</option>
                                        <option value="Maintenance" {{ old('department') == 'Maintenance' ? 'selected' : '' }}>Facilities & Maintenance</option>
                                        <option value="Housekeeping" {{ old('department') == 'Housekeeping' ? 'selected' : '' }}>Housekeeping & Laundry</option>
                                        <option value="Catering" {{ old('department') == 'Catering' ? 'selected' : '' }}>Catering Services</option>
                                        <option value="Security" {{ old('department') == 'Security' ? 'selected' : '' }}>Security Operations</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">Complete Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection