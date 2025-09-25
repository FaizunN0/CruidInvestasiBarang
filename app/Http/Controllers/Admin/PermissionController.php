<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function edit(User $user)
    {
        $permissions = Permission::all();
        return view('admin.accounts.permissions', compact('user', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $ids = Permission::whereIn('name', $data['permissions'] ?? [])->pluck('id')->toArray();
        $user->permissions()->sync($ids);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Permissions berhasil diperbarui.');
    }
}
