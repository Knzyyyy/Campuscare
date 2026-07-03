<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('fakultas', 'prodi')->latest();
        if ($request->role)     $query->where('role', $request->role);
        if ($request->search)   $query->where(fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%"));
        $users     = $query->paginate(20)->withQueryString();
        $fakultas  = Fakultas::all();
        return view('superadmin.users.index', compact('users', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $prodis   = Prodi::all();
        return view('superadmin.users.create', compact('fakultas', 'prodis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:mahasiswa,dosen,admin_prodi,admin_fakultas,staff,super_admin',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'nim'         => $request->nim,
            'nip'         => $request->nip,
            'fakultas_id' => $request->fakultas_id,
            'prodi_id'    => $request->prodi_id,
            'is_active'   => true,
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $fakultas = Fakultas::all();
        $prodis   = Prodi::all();
        return view('superadmin.users.edit', compact('user', 'fakultas', 'prodis'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:mahasiswa,dosen,admin_prodi,admin_fakultas,staff,super_admin',
        ]);

        $data = $request->only('name', 'email', 'role', 'nim', 'nip', 'fakultas_id', 'prodi_id');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleAktif(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "User berhasil {$status}.");
    }
}