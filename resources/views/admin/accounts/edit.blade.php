{{-- resources/views/admin/accounts/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-lg">
      <div class="card-header bg-warning text-dark">
        <i class="bi bi-pencil-square me-2"></i> Edit Akun
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.accounts.update', $user->id) }}">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
              <option value="user" {{ old('role', $user->role) == 'user' ? 'selected':'' }}>User</option>
              <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected':'' }}>Admin</option>
              <option value="super" {{ old('role', $user->role) == 'super' ? 'selected':'' }}>Super</option>
            </select>
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">← Batal</a>
            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
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
  title: 'Ada kesalahan',
  html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif
@endpush
