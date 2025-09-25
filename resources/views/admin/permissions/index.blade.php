@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
  <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg,#7f00ff,#e100ff,#00c6ff); color:#fff;">
    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Manajemen Permissions User</h5>
  </div>
  <div class="card-body">
    <div class="table-wrapper">
      <table id="permTable" class="table table-striped datatable">
        <thead>
          <tr>
            <th>Nama</th><th>Email</th><th>Role</th><th>Permissions</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ ucfirst($u->role) }}</td>
            <td>
              @forelse($u->permissions as $p)
                <span class="badge bg-info text-dark">{{ $p->label }}</span>
              @empty
                <span class="text-muted">Tidak ada</span>
              @endforelse
            </td>
            <td>
              <a href="{{ route('admin.permissions.edit', $u->id) }}" class="btn btn-sm btn-secondary">Atur Permissions</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    $('#permTable').DataTable({
        responsive:true,
        destroy: true,
        pageLength:7,
        language:{
            search:"🔍 Cari:", lengthMenu:"Tampilkan _MENU_ data",
            zeroRecords:"Tidak ada data", info:"Menampilkan _START_ - _END_ dari _TOTAL_"
        }
    });
});
@if(session('success'))
Swal.fire({icon:'success', title:'Berhasil', text:"{{ session('success') }}", timer:1800, showConfirmButton:false});
@endif
@if(session('error'))
Swal.fire({icon:'error', title:'Gagal', text:"{{ session('error') }}"});
@endif
</script>
@endpush
