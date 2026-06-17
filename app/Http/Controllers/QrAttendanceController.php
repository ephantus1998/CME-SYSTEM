<?php

namespace App\Http\Controllers;

use App\Models\Cme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class QrAttendanceController extends Controller
{
    /**
     * Display the control panel where admin sets the active duration
     */
    public function showGenerator(Request $request, $id)
    {
        $cme = Cme::findOrFail($id);
        
        // Explicitly cast the string request input to a strict integer for PHP 8.4 compatibility
        $minutes = (int) $request->input('minutes', 15);
        
        // Generate a secure URL that automatically expires after $minutes
        $signedUrl = URL::temporarySignedRoute(
            'attendance.scan', 
            now()->addMinutes($minutes), 
            ['cme' => $cme->id]
        );

        return view('cmes.qr_generator', compact('cme', 'signedUrl', 'minutes'));
    }

    /**
     * Process the scanned QR code and seamlessly forward them to the register sheet or reject them
     */
    public function processScan(Request $request, Cme $cme)
    {
        // Automatically check if the URL signature has been altered OR if the timestamp window has passed
        if (! $request->hasValidSignature()) {
            return response()->view('errors.link_expired', [], 403);
        }

        // If valid, store the CME ID in the user session so the registration form knows which event they are checking into
        session(['active_cme_id' => $cme->id]);

        // Redirect them directly to your existing registration sheet form view 
        return redirect()->route('staff.register')
            ->with('info', 'You are registering attendance for: ' . $cme->title);
    }
}