<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::all();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super,admin,user'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role
        ]);

        return redirect()->route('admin.accounts.index')->with('success','Akun berhasil dibuat.');
    }

    // <-- PERUBAHAN PENTING: gunakan param User $user dan kirim 'user' ke view
    public function edit(User $user)
    {
        return view('admin.accounts.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:7',
            'role' => 'required|in:super,admin,user'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.accounts.index')->with('success','Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.accounts.index')->with('success','Akun berhasil dihapus.');
    }
}
