@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <i class="bi bi-person-plus me-2"></i> Tambah Akun
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.accounts.store') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
              <option value="">-- Pilih Role --</option>
              <option value="super" {{ old('role') == 'super' ? 'selected' : '' }}>Super Admin</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">← Batal</a>
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
