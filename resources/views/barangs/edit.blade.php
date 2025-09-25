@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-lg">
      <div class="card-header bg-warning text-dark">
        <i class="bi bi-pencil-square me-2"></i> Edit Barang
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('barang.update', $barang) }}">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah) }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" class="form-control">
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-warning">🔄 Update</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">← Batal</a>
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
  icon: 'error',
  title: 'Oops! Ada kesalahan',
  html: `{!! implode('<br>', $errors->all()) !!}`,
  confirmButtonText: 'Perbaiki'
});
</script>
@endif
@endpush
