<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cme;
use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request, $cmeId)
    {
        // 1. Ensure the CME session exists
        $cme = Cme::findOrFail($cmeId);
        
        // 2. Fetch the checkbox array from the view (Matches name="attendance[...]").
        $attendanceData = $request->input('attendance', []);

        // 3. Get all registered staff IDs to process the full grid state
        $staffIds = Staff::pluck('id')->toArray();

        // 4. Iterate through every staff member to determine their state
        foreach ($staffIds as $staffId) {
            // If the staff ID is present in the array, mark them 'Present', otherwise 'Absent'
            $status = isset($attendanceData[$staffId]) ? 'Present' : 'Absent';

            // 5. Update the row if it exists, or create a new one cleanly
            Attendance::updateOrCreate(
                [
                    'cme_id'   => $cme->id,
                    'staff_id' => $staffId,
                ],
                [
                    'status'   => $status,
                ]
            );
        }

        // 6. Return back to the sheet with an alert feedback banner
        return redirect()->route('cmes.show', $cme->id)->with('success', 'Attendance updated successfully!');
    }
}