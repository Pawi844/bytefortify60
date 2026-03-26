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
        return view('admin.portal.login');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        $attendee = Attendee::where('email', $request->email)->first();

        // Password = stored portal_password OR first 6 chars of email
        $defaultPassword = substr($request->email, 0, 6);
        $validPassword = $attendee && (
            $request->password === $attendee->portal_password ||
            $request->password === $defaultPassword
        );

        if ($attendee && $validPassword) {
            session([
                'attendee_id'    => $attendee->id,
                'attendee_name'  => $attendee->first_name . ' ' . $attendee->last_name,
                'attendee_email' => $attendee->email,
                'attendee_event' => $attendee->event_id,
            ]);
            return redirect()->route('portal.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials. Use your registration email. Password = first 6 characters of your email address.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['attendee_id','attendee_name','attendee_email','attendee_event']);
        return redirect()->route('portal.login');
    }
}