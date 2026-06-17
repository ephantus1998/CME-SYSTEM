<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cme;
use App\Models\Staff;
use Illuminate\Http\Request;

class CmeController extends Controller
{
    /**
     * Display a listing of all scheduled CME sessions.
     */
    public function index()
    {
        $cmes = Cme::withCount('attendances')->orderBy('date', 'desc')->get();
        return view('cmes.index', compact('cmes'));
    }

    /**
     * Show the form for creating a new CME session.
     */
    public function create()
    {
        return view('cmes.create');
    }

    /**
     * Store a newly created CME session in storage and
     * immediately redirect to the QR code generation control panel.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'facilitator' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // 1. Persist the new CME session row to the database
        $cme = Cme::create($validated);

        // 2. Automate the redirection layout straight to your dynamic QR code generator dashboard
        return redirect()->route('cmes.qr.generator', $cme->id)
            ->with('success', 'CME Session scheduled successfully! Set your active duration timer below to project the QR code.');
    }

    /**
     * View a specific CME session with a live audit counter and department metrics.
     */
    public function show($id)
    {
        // 1. Fetch the CME session along with its related staff attendance records and profile models
        $cme = Cme::with(['attendances.staff'])->findOrFail($id);
        
        // 2. Calculate total headcount present
        $totalAttendance = $cme->attendances->count();

        // 3. Group and count attendances by staff department for progress bar charting
        $departmentMetrics = $cme->attendances->groupBy(function($attendance) {
            return $attendance->staff->department ?? 'Unassigned';
        })->map(function($group) {
            return $group->count();
        })->sortByDesc(fn($count) => $count);

        // 4. Send ALL necessary dashboard variables to the view layout
        return view('cmes.show', compact('cme', 'totalAttendance', 'departmentMetrics'));
    }

    /**
     * Show the form for editing an existing CME session.
     */
    public function edit($id)
    {
        $cme = Cme::findOrFail($id);
        return view('cmes.edit', compact('cme'));
    }

    /**
     * Update an existing CME session in storage.
     */
    public function update(Request $request, $id)
    {
        $cme = Cme::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'facilitator' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $cme->update($validated);

        return redirect()->route('cmes.index')->with('success', 'CME Session updated successfully!');
    }

    /**
     * Remove a CME session and its associated attendance records from storage.
     */
    public function destroy($id)
    {
        $cme = Cme::findOrFail($id);
        
        // Delete related attendances first to maintain database foreign key integrity
        $cme->attendances()->delete();
        $cme->delete();

        return redirect()->route('cmes.index')->with('success', 'CME Session deleted successfully!');
    }

    /**
     * Show the registration form to the scanned staff member.
     */
    public function showRegisterForm()
    {
        return view('staff.register');
    }

    /**
     * Process the staff registration form submission, prevent duplicate entries, 
     * and auto-log attendance safely across multiple scans.
     */
    public function storeStaff(Request $request)
    {
        // 1. Basic validation (Removed the unique constraint to allow existing profiles to submit)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'staff_no' => 'required|string|max:50',
            'department' => 'required|string|max:100',
        ]);

        // 2. Check if this staff member already exists in the system database
        $staff = Staff::where('staff_no', $validated['staff_no'])->first();

        if (! $staff) {
            // Profile does not exist yet; save them as a brand new staff member
            $staff = Staff::create($validated);
        } else {
            // Profile exists; silently update details in case they changed departments
            $staff->update([
                'name' => $validated['name'],
                'department' => $validated['department']
            ]);
        }

        // 3. Verify if they arrived via a valid cryptographic QR code session tracker mapping
        if (session()->has('active_cme_id')) {
            $cmeId = session('active_cme_id');
            $cme = Cme::find($cmeId);

            if ($cme) {
                // 4. PREVENT DOUBLE SIGN-INS: See if this staff member is already on the attendance sheet for THIS session
                $alreadyAttended = $cme->attendances()->where('staff_id', $staff->id)->exists();

                if ($alreadyAttended) {
                    // Flush the tracking session variable to cleanly reset application state
                    session()->forget('active_cme_id');

                    return redirect()->route('cmes.index')
                        ->with('info', "Hello {$staff->name}, you are already checked into the session: '{$cme->title}'.");
                }

                // 5. Fresh check-in entry creation
                $cme->attendances()->create([
                    'staff_id' => $staff->id,
                    'status' => 'Present', 
                ]);

                // Clear temporary tracking parameter
                session()->forget('active_cme_id');

                return redirect()->route('cmes.index')
                    ->with('success', "Welcome {$staff->name}! Your attendance for '{$cme->title}' has been logged successfully.");
            }
        }

        return redirect()->route('cmes.index')->with('success', 'Staff registration profile details updated successfully!');
    }
}