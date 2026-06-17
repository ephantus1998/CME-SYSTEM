<?php

namespace App\Http\Controllers;

use App\Models\Cme;
use App\Models\Staff;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalCmes = Cme::count();
        $totalStaff = Staff::count();
        $averageAttendance = $totalCmes > 0 ? round(Attendance::where('status', 'Present')->count() / $totalCmes, 1) : 0;
        $cmes = Cme::withCount(['attendances as present_count' => function ($query) {
            $query->where('status', 'Present');
        }])->orderBy('date', 'desc')->get();

        return view('reports.index', compact('totalCmes', 'totalStaff', 'averageAttendance', 'cmes'));
    }

    public function exportCmeCsv($id)
    {
        $cme = Cme::findOrFail($id);
        $attendances = Staff::leftJoin('attendances', function($join) use ($cme) {
            $join->on('staff.id', '=', 'attendances.staff_id')->where('attendances.cme_id', '=', $cme->id);
        })->select('staff.staff_no', 'staff.name', 'staff.department', 'attendances.status')->get();

        $fileName = 'CME_Attendance_' . str_replace(' ', '_', $cme->title) . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function() use($cme, $attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Staff Number', 'Full Name', 'Department', 'Status']);
            foreach ($attendances as $row) {
                fputcsv($file, [$row->staff_no, $row->name, $row->department, $row->status ?? 'Absent']);
            }
            fclose($file);
        }, 200, $headers);
    }
}