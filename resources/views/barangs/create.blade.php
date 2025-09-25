{{-- resources/views/barangs/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <i class="bi bi-plus-lg me-2"></i> Tambah Barang
      </div>
      <div class="card-body">
        <form action="{{ route('barang.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="form-control" required>
          </div>

          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label">Jumlah</label>
              <input type="number" name="jumlah" value="{{ old('jumlah',1) }}" class="form-control" min="1" required>
            </div>
            <div class="col">
              <label class="form-label">Satuan</label>
              <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="form-control" required>
          </div>

          {{-- OWNER select hanya untuk super --}}
          @if(isset($usersForSelect) && $usersForSelect->isNotEmpty())
            <div class="mb-3">
              <label class="form-label">Pemilik (Sudo oleh Super Admin)</label>
              <select name="owner_id" class="form-select">
                <option value="">— Pilih pemilik (opsional) —</option>
                @foreach($usersForSelect as $u)
                  <option value="{{ $u->id }}"
                    {{ (old('owner_id') == $u->id) || (isset($selectedOwner) && $selectedOwner == $u->id) ? 'selected' : '' }}>
                    {{ $u->name }} ({{ ucfirst($u->role) }})
                  </option>
                @endforeach
              </select>
              <div class="form-text">Jika dipilih, barang akan dibuat atas nama user tersebut.</div>
            </div>
          @endif

          <div class="d-flex justify-content-between">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">← Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@if ($errors->any())
<script>
Swal.fire({
  icon:'error',
  title:'Ada kesalahan',
  html:`{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif
@endpush
