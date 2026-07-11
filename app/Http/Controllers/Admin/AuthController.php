<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $validUsername = config('admin.username');
        $validPassword = config('admin.password');

        if ($request->username === $validUsername && $request->password === $validPassword) {
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_name', config('admin.name'));
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang, ' . config('admin.name') . '!');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['password' => 'Username atau password salah.']);
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'admin_name']);
        $request->session()->regenerate();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
