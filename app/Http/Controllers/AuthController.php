<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Incorrect username or password.',
        ])->onlyInput('username');
    }

    /**
     * Show admin register form
     */
    public function showRegisterForm()
    {
        return view('auth.admin.register');
    }

    /**
     * Handle admin registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:admin'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $admin = \App\Models\Admin::create([
            'username' => $request->username,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('auth.admin.login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Handle admin password reset
     */
    public function reset(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = Auth::guard('admin')->user();

        if ($admin instanceof Admin) {
            $admin->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return back()->with('status', 'Password berhasil diubah.');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin.login');
    }
}
