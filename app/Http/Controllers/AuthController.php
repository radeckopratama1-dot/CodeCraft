<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Handle student authentication.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = trim($credentials['login']);
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $loginInput, 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali di CodeCraft Lab!');
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password tidak cocok dengan data kami.',
        ])->onlyInput('login');
    }

    /**
     * Display the student registration form.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Handle student registration with +50 XP bonus.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'grade_level' => ['required', 'string', 'in:Kelas 7,Kelas 8,Kelas 9'],
            'avatar' => ['nullable', 'string', 'in:cyber-bot,code-wizard,network-ninja,pixel-hero'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.unique' => 'Username ini sudah digunakan siswa lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda strip, atau garis bawah.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter agar aman.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'grade_level' => $validated['grade_level'],
            'avatar' => $validated['avatar'] ?? 'cyber-bot',
            'password' => Hash::make($validated['password']),
            'xp' => 50, // Bonus pendaftaran siswa baru
            'level' => 1,
            'streak_days' => 1,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Kamu mendapatkan bonus awal +50 XP 🚀');
    }

    /**
     * Quick 1-click Demo Student login.
     */
    public function demoLogin(Request $request): RedirectResponse
    {
        $demoUser = User::where('email', 'siswa@codecraft.test')
            ->orWhere('username', 'siswa_demo')
            ->first();

        if (!$demoUser) {
            $demoUser = User::create([
                'name' => 'Rafi Pratama (Siswa SMP)',
                'username' => 'siswa_demo',
                'email' => 'siswa@codecraft.test',
                'grade_level' => 'Kelas 8',
                'password' => Hash::make('password123'),
                'xp' => 1250,
                'level' => 4,
                'streak_days' => 7,
                'avatar' => 'cyber-bot',
            ]);
        }

        Auth::login($demoUser);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Berhasil masuk dengan Akun Demo Siswa! ⚡');
    }

    /**
     * Log the student out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Kamu telah keluar dari akun CodeCraft.');
    }
}
