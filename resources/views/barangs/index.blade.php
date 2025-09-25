{{-- resources/views/barangs/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
      <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Barang Saya</h5>

      {{-- Super: pilih acting user (sudo view) --}}
      @if(isset($users) && $users->isNotEmpty())
        <form method="GET" class="d-flex align-items-center" style="gap:.5rem;">
          <label class="mb-0 text-muted small">Tindakan sebagai</label>
          <select name="as_user" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">— Semua (No Acting) —</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}" {{ (isset($actingUser) && $actingUser && $actingUser->id == $u->id) ? 'selected' : '' }}>
                {{ $u->name }} ({{ ucfirst($u->role) }})
              </option>
            @endforeach
          </select>
        </form>
      @endif
    </div>

    <div>
      @if(auth()->user()->isSuper() || auth()->user()->hasPermission('create'))
        {{-- jika actingUser ada, tambahkan query string agar create preselect owner --}}
        <a href="{{ route('barang.create') }}{{ isset($actingUser) && $actingUser ? '?as_user='.$actingUser->id : '' }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
      @endif
    </div>
  </div>

  <div class="card-body">
    <div class="table-wrapper">
      <table id="myBarangTable" class="table table-striped datatable">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>Pemilik</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($barangs as $b)
          <tr>
            <td>{{ $b->kode_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->jumlah }}</td>
            <td>{{ $b->satuan }}</td>
            <td>{{ $b->lokasi }}</td>
            <td>{{ $b->user->name ?? '-' }}</td>
            <td>
              {{-- Edit --}}
              @if(
                auth()->user()->isSuper() ||
                (auth()->user()->isAdmin() && auth()->user()->hasPermission('update')) ||
                (auth()->user()->hasPermission('update') && $b->user_id == auth()->id())
              )
                <a href="{{ route('barang.edit', $b) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
              @endif

              {{-- Delete --}}
              @if(
                auth()->user()->isSuper() ||
                (auth()->user()->isAdmin() && auth()->user()->hasPermission('delete')) ||
                (auth()->user()->hasPermission('delete') && $b->user_id == auth()->id())
              )
                <form action="{{ route('barang.destroy', $b) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash"></i></button>
                </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
