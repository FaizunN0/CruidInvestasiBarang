{{-- resources/views/barangs/daftar.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
  <div class="card-header d-flex justify-content-between align-items-center" 
       style="background: linear-gradient(135deg,#7f00ff,#e100ff,#00c6ff); color:#fff;">
    <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i> Daftar Barang</h5>
    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel">
      <i class="bi bi-funnel"></i> Filter
    </button>
  </div>

  <div id="filterPanel" class="collapse">
    <div class="card-body bg-light">
      <form method="GET" action="{{ route('barang.daftar') }}" class="row g-3 align-items-start">
        <div class="col-md-6">
          <label class="form-label fw-bold">Pilih User</label>
          <div class="border rounded p-2" style="max-height:220px; overflow:auto;">
            @php $selectedUsers = (array) request('users', []); @endphp
            @foreach($users as $u)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="users[]" value="{{ $u->id }}"
                       id="u{{ $u->id }}" {{ in_array($u->id, $selectedUsers) ? 'checked' : '' }}>
                <label class="form-check-label" for="u{{ $u->id }}">
                  {{ $u->name }} ({{ ucfirst($u->role) }})
                </label>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-md-4">
          <label class="form-label fw-bold">Lokasi</label>
          <input type="text" name="lokasi" class="form-control" value="{{ request('lokasi') }}" placeholder="Contoh: Gudang A">
        </div>

        <div class="col-md-2 d-grid">
          <button class="btn btn-secondary w-100 mt-2"><i class="bi bi-search"></i> Terapkan</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card-body">
    <div class="table-wrapper">
      <table id="daftarTable" class="table table-striped datatable">
        <thead>
          <tr>
            <th>Pemilik</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            @if(auth()->user()->isSuper() || (auth()->user()->isAdmin() && auth()->user()->hasAnyPermission(['update','delete'])))
              <th>Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($barangs as $b)
          <tr>
            <td>{{ $b->user->name ?? '-' }}</td>
            <td>{{ $b->kode_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->jumlah }}</td>
            <td>{{ $b->satuan }}</td>
            <td>{{ $b->lokasi }}</td>

            @if(auth()->user()->isSuper() || (auth()->user()->isAdmin() && auth()->user()->hasAnyPermission(['update','delete'])))
            <td>
              @if(auth()->user()->isSuper() || (auth()->user()->isAdmin() && auth()->user()->hasPermission('update')))
                <a href="{{ route('barang.edit', $b) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
              @endif

              @if(auth()->user()->isSuper() || (auth()->user()->isAdmin() && auth()->user()->hasPermission('delete')))
                <form action="{{ route('barang.destroy', $b) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash"></i></button>
                </form>
              @endif
            </td>
            @endif
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
  $('#daftarTable').DataTable({
    destroy:true,
    responsive:true,
    pageLength:7,
    language:{
      search:"🔍 Cari:", lengthMenu:"Tampilkan _MENU_ data",
      zeroRecords:"Tidak ada data", info:"Menampilkan _START_ - _END_ dari _TOTAL_"
    }
  });

  // konfirmasi hapus
  $(document).on('click','.btn-delete',function(){
    let form = $(this).closest('form');
    Swal.fire({
      title:'Yakin hapus?', text:'Data barang akan dihapus permanen',
      icon:'warning', showCancelButton:true,
      confirmButtonColor:'#e100ff', cancelButtonColor:'#6c757d',
      confirmButtonText:'Ya, hapus', cancelButtonText:'Batal'
    }).then((res)=>{ if(res.isConfirmed) form.submit(); });
  });
});
</script>
@endpush
