<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionManagerController extends Controller
{
    public function index()
    {
        // Kalau super admin → semua user kecuali super
        if (Auth::user()->isSuper()) {
            $users = User::where('role', '!=', 'super')->get();
        } else {
            // Kalau admin → hanya user
            $users = User::where('role', 'user')->get();
        }

        return view('admin.permissions.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Kalau admin coba akses admin lain → tolak
        if (Auth::user()->isAdmin() && $user->role !== 'user') {
            abort(403, 'Anda tidak punya akses untuk mengatur permissions admin lain.');
        }

        $permissions = Permission::all();
        return view('admin.permissions.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        // Admin hanya boleh update permissions user
        if (Auth::user()->isAdmin() && $user->role !== 'user') {
            abort(403, 'Anda tidak punya akses untuk mengatur permissions admin lain.');
        }

        $selected = $request->input('permissions', []);
        $user->permissions()->sync($selected);

        return redirect()->route('admin.permissions.index')->with('success', 'Permissions untuk ' . $user->name . ' berhasil diperbarui.');
    }
}
