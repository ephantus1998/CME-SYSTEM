<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a comprehensive directory of all registered staff profiles.
     */
    public function index(Request $request)
    {
        $query = Staff::withCount('attendances');

        // Simple search query matching for administration ease
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('staff_no', 'like', "%{$searchTerm}%")
                  ->orWhere('department', 'like', "%{$searchTerm}%");
        }

        $staffMembers = $query->orderBy('name', 'asc')->get();

        return view('staff.index', compact('staffMembers'));
    }

    /**
     * View an individual staff profile with their full lifetime CME training history logs.
     */
    public function show($id)
    {
        $staff = Staff::with(['attendances.cme' => function($q) {
            $q->orderBy('date', 'desc');
        }])->findOrFail($id);

        return view('staff.show', compact('staff'));
    }

    /**
     * Show the profile edit form to correct typos.
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the staff profile records in database storage.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'staff_no' => "required|string|max:50|unique:staff,staff_no,{$id}",
            'department' => 'required|string|max:255', // Expanded to perfectly accommodate longer department strings securely
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')
            ->with('success', "Staff record for {$staff->name} was updated successfully!");
    }
}