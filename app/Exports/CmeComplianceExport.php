<?php

namespace App\Exports;

use App\Models\Staff;
use App\Models\Cme;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CmeComplianceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $totalCmes;

    public function __construct()
    {
        $this->totalCmes = Cme::count();
    }

    public function collection()
    {
        return Staff::with(['attendances' => function($query) {
            $query->where('status', 'Present');
        }])->get();
    }

    public function headings(): array
    {
        return [
            'Staff No',
            'Full Name',
            'Department',
            'Sessions Attended',
            'Total Sessions',
            'Compliance Percentage'
        ];
    }

    public function map($staff): array
    {
        $attendedCount = $staff->attendances->count();
        $percentage = $this->totalCmes > 0 ? round(($attendedCount / $this->totalCmes) * 100, 1) : 0;

        return [
            $staff->staff_no,
            $staff->name,
            $staff->department,
            $attendedCount,
            $this->totalCmes,
            $percentage . '%'
        ];
    }
}