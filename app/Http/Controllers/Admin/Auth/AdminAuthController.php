<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login attempt
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate admin
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Authentication failed
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        // Logout the admin
        Auth::guard('admin')->logout();

        // Invalidate session and regenerate token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to admin login page
        return redirect()->route('admin.login');
    }
}
