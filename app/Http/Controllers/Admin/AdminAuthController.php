<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'admin@eventpro.com'   => ['password' => 'admin123',   'name' => 'Admin',   'role' => 'Super Admin'],
            'manager@eventpro.com' => ['password' => 'manager123', 'name' => 'Manager', 'role' => 'Event Manager'],
            'staff@eventpro.com'   => ['password' => 'staff123',   'name' => 'Staff',   'role' => 'Staff'],
        ];

        $email = $request->email;
        if (isset($credentials[$email]) && $credentials[$email]['password'] === $request->password) {
            session([
                'admin_logged_in' => true,
                'admin_name'      => $credentials[$email]['name'],
                'admin_email'     => $email,
                'admin_role'      => $credentials[$email]['role'],
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials. Please try again.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login');
    }
}