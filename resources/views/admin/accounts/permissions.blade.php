@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
  <div class="card-header bg-info text-white">
    <i class="bi bi-shield-lock me-2"></i> Atur Permissions: {{ $user->name }}
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.users.permissions.update', $user) }}">
      @csrf @method('PUT')

      <div class="table-wrapper">
        <table class="table table-striped datatable">
          <thead>
            <tr>
              <th>Permission</th>
              <th>Label</th>
              <th>Aktif</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $p)
            <tr>
              <td>{{ $p->name }}</td>
              <td>{{ $p->label }}</td>
              <td>
                <input type="checkbox" name="permissions[]" value="{{ $p->id }}"
                  {{ $user->permissions->contains('id', $p->id) ? 'checked' : '' }}>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">← Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
{{-- DataTable init --}}
<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        pageLength: 7,
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            paginate: { previous: "‹", next: "›" }
        }
    });
});
</script>

{{-- SweetAlert2 untuk sukses / error --}}
@if(session('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: "{{ session('success') }}",
  timer: 2000,
  showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
  icon: 'error',
  title: 'Oops!',
  text: "{{ session('error') }}",
  confirmButtonText: 'OK'
});
</script>
@endif

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
