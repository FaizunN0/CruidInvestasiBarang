<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Barang;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPermissionController extends Controller
{
    /**
     * Tampilkan form edit permission untuk user tertentu
     */
    public function edit(User $user)
    {
        // Hanya Super Admin bisa atur semua
        // Admin hanya bisa atur user biasa
        if (auth()->user()->isAdmin() && $user->role !== 'user') {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Admin hanya bisa mengatur permissions user.');
        }

        $permissions = Permission::all();
        return view('admin.accounts.permissions', compact('user', 'permissions'));
    }

    /**
     * Update permissions user
     */
    public function update(Request $request, User $user)
    {
        // validasi input
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        // Super Admin bisa atur siapa saja
        // Admin hanya boleh atur user
        if (auth()->user()->isAdmin() && $user->role !== 'user') {
            return redirect()->route('admin.accounts.index')
                ->with('error', 'Admin tidak boleh mengatur permissions admin/super.');
        }

        // sync permissions
        $user->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Permissions untuk ' . $user->name . ' berhasil diperbarui.');
    }
    public function daftar(Request $request)
{
    $q = Barang::with('user');

    if ($request->filled('users')) {
        $q->whereIn('user_id', $request->users);
    }
    if ($request->filled('lokasi')) {
        $q->where('lokasi', 'like', '%'.$request->lokasi.'%');
    }

    $barangs = $q->get();
    $users = User::all();
    return view('barangs.daftar', compact('barangs','users'));
}

}
