<?php

namespace App\Http\Controllers\Attendee;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeAuthController extends Controller
{
    public function showLogin()
    {
        if (session('attendee_id')) return redirect()->route('portal.dashboard');
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        $attendee = Attendee::where('email', $request->email)->first();
        if ($attendee && ($request->password === $attendee->portal_password || $request->password === substr($attendee->email, 0, 6))) {
            session([
                'attendee_id'    => $attendee->id,
                'attendee_name'  => $attendee->first_name . ' ' . $attendee->last_name,
                'attendee_email' => $attendee->email,
                'attendee_event' => $attendee->event_id,
            ]);
            return redirect()->route('portal.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials. Use your registration email and first 6 characters of email as password.']);
    }

    public function logout()
    {
        session()->forget(['attendee_id','attendee_name','attendee_email','attendee_event']);
        return redirect()->route('portal.login');
    }
}