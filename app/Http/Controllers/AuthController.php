<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    private const MAX_ATTEMPTS = 3;
    private const LOCKOUT_MINUTES = 1;

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

        $username = $credentials['username'];
        
        if ($this->isLockedOut($username)) {
            $lockoutTime = Cache::get($this->getLockoutKey($username));
            return back()->withErrors([
                'username' => "Akun terkunci. Silakan coba lagi dalam {$lockoutTime} detik.",
            ])->onlyInput('username');
        }

        $user = User::where('username', $username)->where('role', 'admin')->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $this->resetAttempts($username);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        $this->incrementAttempts($username);
        $attempts = $this->getAttempts($username);
        
        if ($attempts >= self::MAX_ATTEMPTS) {
            $this->lockoutAccount($username);
            return back()->withErrors([
                'username' => 'Akun terkunci karena terlalu banyak percobaan login gagal. Coba lagi dalam 1 menit.',
            ])->onlyInput('username');
        }

        $remainingAttempts = self::MAX_ATTEMPTS - $attempts;
        return back()->withErrors([
            'username' => "Username atau password salah. Sisa percobaan: {$remainingAttempts}",
        ])->onlyInput('username');
    }

    /**
     * Get the cache key for login attempts
     */
    private function getAttemptsKey($username)
    {
        return "login_attempts_{$username}";
    }

    /**
     * Get the cache key for lockout
     */
    private function getLockoutKey($username)
    {
        return "login_lockout_{$username}";
    }

    /**
     * Get current number of failed attempts
     */
    private function getAttempts($username)
    {
        return Cache::get($this->getAttemptsKey($username), 0);
    }

    /**
     * Increment failed login attempts
     */
    private function incrementAttempts($username)
    {
        $attemptsKey = $this->getAttemptsKey($username);
        Cache::put($attemptsKey, $this->getAttempts($username) + 1, now()->addMinutes(self::LOCKOUT_MINUTES));
    }

    /**
     * Reset login attempts
     */
    private function resetAttempts($username)
    {
        Cache::forget($this->getAttemptsKey($username));
        Cache::forget($this->getLockoutKey($username));
    }

    /**
     * Lock out the account temporarily
     */
    private function lockoutAccount($username)
    {
        $lockoutKey = $this->getLockoutKey($username);
        Cache::put($lockoutKey, self::LOCKOUT_MINUTES * 60, now()->addMinutes(self::LOCKOUT_MINUTES));
    }

    /**
     * Check if account is currently locked out
     */
    private function isLockedOut($username)
    {
        return Cache::has($this->getLockoutKey($username));
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
     * Changed to save admin data to users table with role 'admin' instead of admin table
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        User::create([
            'username' => $request->username,
            'email' => null,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please login.');
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

        $user = Auth::guard('admin')->user();

        if ($user instanceof User) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return back()->with('status', 'Password berhasil diubah.');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        return view('home');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
