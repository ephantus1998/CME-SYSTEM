<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QrAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;

// -------------------------------------------------------------
// Root & Landing Redirection Matrix
// -------------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('cmes.index');
});

// -------------------------------------------------------------
// Guest & Public Access Routes (No Login Required)
// -------------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// QR Code Smartphone Scanning Web Hooks
Route::get('/scan-attendance/{cme}', [QrAttendanceController::class, 'processScan'])->name('attendance.scan');

// Staff Self-Registration & Form Check-In Actions
Route::get('/register-staff', [CmeController::class, 'showRegisterForm'])->name('staff.register');
Route::post('/register-staff', [CmeController::class, 'storeStaff'])->name('staff.store');
Route::post('/cmes/{cme}/attendance', [AttendanceController::class, 'store'])->name('attendance.store');


// -------------------------------------------------------------
// Administrative Guarded Management Routes (Login Enforced)
// -------------------------------------------------------------
Route::middleware(['admin.auth'])->group(function () {
    
    // Secure Session Destruction Link
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // CME Operational Resource Pipelines
    Route::resource('cmes', CmeController::class);

    // QR Code Screen Automation Generators
    Route::get('/cmes/{id}/qr-generator', [QrAttendanceController::class, 'showGenerator'])->name('cmes.qr.generator');

    // Analytics Reporting & File Compilation Frameworks
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/cme/{id}/export-csv', [ReportController::class, 'exportCmeCsv'])->name('reports.export.csv');

    // Staff Directory & Professional Record Audit Routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    
});