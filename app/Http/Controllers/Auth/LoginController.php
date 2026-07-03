<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['identifier'])
            ->orWhere('nim', $credentials['identifier'])
            ->orWhere('nip', $credentials['identifier'])
            ->first();

        if (! $user || ! $user->is_active) {
            return back()
                ->withInput($request->only('identifier'))
                ->with('error', 'Email/NIM/NIP atau kata sandi salah.');
        }

        if (! Auth::attempt(['email' => $user->email, 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('identifier'))
                ->with('error', 'Email/NIM/NIP atau kata sandi salah.');
        }

        $request->session()->regenerate();

        Auth::user()->update(['last_login_at' => now()]);

        $role = Auth::user()->role;

        return $this->redirectByRole($role);
    }

    /**
     * Logout pengguna dan redirect ke halaman login.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }

    /**
     * Redirect ke dashboard sesuai role pengguna.
     */
    private function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            User::ROLE_MAHASISWA, User::ROLE_DOSEN => redirect()->route('mahasiswa.dashboard'),
            User::ROLE_ADMIN_PRODI, User::ROLE_ADMIN_FAKULTAS => redirect()->route('admin.dashboard'),
            User::ROLE_STAFF => redirect()->route('staff.dashboard'),
            User::ROLE_SUPER_ADMIN => redirect()->route('superadmin.dashboard'),
            default => redirect('/'),
        };
    }
}
