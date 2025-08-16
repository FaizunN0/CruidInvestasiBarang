  {{-- jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅 --}}
@extends('layouts.app')

@section('content')
  <h2 class="text-white mb-3">📦 Data Barang</h2>

  <!-- Controls: Tombol Tambah + Search placeholder -->
  <div class="table-controls">
    <a href="{{ route('barangs.create') }}" class="btn btn-primary">
      ➕ Tambah Barang
    </a>
    <div id="dt-search-placeholder"></div>
  </div>

  <!-- Tabel sing bisa munggah mudhun -->
  <div class="table-wrapper">
    <table id="myTable" class="table table-hover mb-0" style="width:100%">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Lokasi</th>
          <th class="text-center">Aksi</th>
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
            <td class="text-center">
              <a href="{{ route('barangs.edit', $b) }}" class="btn btn-warning btn-sm me-1">✏️</a>
              <button type="button" class="btn btn-danger btn-sm btn-delete"
                      data-id="{{ $b->id }}" data-name="{{ $b->nama_barang }}">🗑️</button>
              <form id="delete-form-{{ $b->id }}" action="{{ route('barangs.destroy', $b) }}" method="POST" class="d-none">
                @csrf @method('DELETE')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination container -->
  <div class="pagination-wrapper"></div>
@endsection

@push('scripts')
<script>
  $(function() {
    // Ngetung dawa kaca miturut jembar layar
    const w = $(window).width();
    let pageLength = 7;
    if (w <= 576)       pageLength = 5;
    else if (w <= 768)  pageLength = 6;
    else if (w <= 1024) pageLength = 17;

    // Inisialisasi DataTable: 'f' kanggo filter, 't' kanggo tabel, 'p' kanggo nomer-nomeran
    const table = $('#myTable').DataTable({
      pageLength:   pageLength,
      lengthChange: false,
      ordering:     true,
      info:         false,
      autoWidth:    false,
      dom:          'f t <"pagination-wrapper"p>',
      language: {
        search: "",
        searchPlaceholder: "🔍 Cari...",
        paginate: {
          previous: "‹",
          next:     "›"
        }
      }
    });

    // Pindahkan search input ke placeholder di controls
    $('#dt-search-placeholder').append( $('.dataTables_filter') );

    // Konfirmasi delete
    $('.btn-delete').on('click', function() {
      const id   = $(this).data('id'),
            name = $(this).data('name');
      Swal.fire({
        title: `Hapus “${name}”?`,
        text: 'Data akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: 'btn btn-danger me-2',
          cancelButton:  'btn btn-secondary'
        },
        buttonsStyling: false
      }).then(res => {
        if (res.isConfirmed) {
          $('#delete-form-' + id).submit();
        }
      });
    });

    // Flash sukses
    @if(session('success'))
      Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Oke',
        customClass: { confirmButton: 'btn btn-primary' },
        buttonsStyling: false
      });
    @endif
  });
</script>
@endpush
