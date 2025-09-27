<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * BARANG (index) - halaman kelola personal.
     * Jika super & ?as_user=ID maka tampilkan barang user tersebut (sudo view).
     * Jika super & tanpa as_user => tampilkan semua.
     */
    public function index(Request $request)
    {
        $auth = auth()->user();

        // jika super, kirim list user ke view supaya dropdown acting tersedia
        $users = $auth->isSuper() ? User::orderBy('name')->get() : collect();

        $actingUser = null;
        if ($auth->isSuper() && $request->filled('as_user')) {
            $actingUser = User::find($request->as_user);
        }

        $query = Barang::with('user');

        if ($actingUser) {
            // super acting as selected user
            $query->where('user_id', $actingUser->id);
        } else {
            // default: user & admin lihat barang milik sendiri; super (no acting) lihat semua
            if ($auth->isUser() || $auth->isAdmin()) {
                $query->where('user_id', $auth->id);
            }
            // super without acting -> no where (all)
        }

        $barangs = $query->get();

        return view('barangs.index', compact('barangs', 'users', 'actingUser'));
    }

    /**
     * DAFTAR - global read-only listing with filter (checkbox user + lokasi)
     */
    public function daftar(Request $request)
    {
        $auth = auth()->user();
        $query = Barang::with('user');

        // users may be array from checkboxes
        $selectedUsers = (array) $request->input('users', []);
        if (!empty($selectedUsers)) {
            $query->whereIn('user_id', $selectedUsers);
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // jika kode di bawah ini dihidupkan, user hanya lihat barang milik sendiri
        // if ($auth->isUser()) {
        //     $query->where('user_id', $auth->id);
        // }

        $barangs = $query->get();
        $users = User::orderBy('name')->get();

        return view('barangs.daftar', compact('barangs', 'users'));
    }

    /**
     * create form
     * super admin gets owner select; others don't
     */
    public function create(Request $request)
    {
        $auth = auth()->user();

        if (!($auth->isSuper() || $auth->hasPermission('create'))) {
            return redirect()->route('barang.index')->with('error', 'Anda tidak punya izin menambah barang.');
        }

        $usersForSelect = $auth->isSuper() ? User::orderBy('name')->get() : collect();
        // preselect owner if ?as_user=...
        $selectedOwner = $request->query('as_user') ?: null;

        return view('barangs.create', compact('usersForSelect', 'selectedOwner'));
    }

    /**
     * store
     */
    public function store(Request $request)
    {
        $auth = auth()->user();

        if (!($auth->isSuper() || $auth->hasPermission('create'))) {
            return redirect()->route('barang.index')->with('error', 'Anda tidak punya izin menambah barang.');
        }

        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:150',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:50',
            'lokasi'      => 'required|string|max:150',
            'owner_id'    => 'nullable|exists:users,id'
        ]);

        $ownerId = $auth->id;
        if ($auth->isSuper() && $request->filled('owner_id')) {
            $ownerId = (int) $request->owner_id;
        }

        $validated['user_id'] = $ownerId;

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * edit
     */
    public function edit(Barang $barang)
    {
        $auth = auth()->user();

        // Super admin boleh edit semua
        if ($auth->isSuper()) {
            return view('barangs.edit', compact('barang'));
        }

        // Admin boleh jika punya permission update
        if ($auth->isAdmin() && $auth->hasPermission('update')) {
            return view('barangs.edit', compact('barang'));
        }

        // User hanya barang sendiri + punya permission update
        if ($auth->isUser() && $barang->user_id == $auth->id && $auth->hasPermission('update')) {
            return view('barangs.edit', compact('barang'));
        }

        return redirect()->route('barang.index')->with('error', 'Anda tidak punya izin mengedit barang ini.');
    }

    /**
     * update
     */
    public function update(Request $request, Barang $barang)
    {
        $auth = auth()->user();

        $allowed = $auth->isSuper()
            || ($auth->isAdmin() && $auth->hasPermission('update'))
            || ($auth->isUser() && $barang->user_id == $auth->id && $auth->hasPermission('update'));

        if (!$allowed) {
            return redirect()->route('barang.index')->with('error', 'Anda tidak punya izin mengupdate barang ini.');
        }

        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:150',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:50',
            'lokasi'      => 'required|string|max:150',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * destroy
     */
    public function destroy(Barang $barang)
    {
        $auth = auth()->user();

        $allowed = $auth->isSuper()
            || ($auth->isAdmin() && $auth->hasPermission('delete'))
            || ($auth->isUser() && $barang->user_id == $auth->id && $auth->hasPermission('delete'));

        if (!$allowed) {
            return redirect()->route('barang.index')->with('error', 'Anda tidak punya izin menghapus barang ini.');
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
