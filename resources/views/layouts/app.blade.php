<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CruidInventarisBarang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #7f00ff 0%, #e100ff 50%, #00c6ff 100%);
            color: #2b2b2b;
            min-height: 100vh;
            margin: 0;
            padding-top: 56px; /* sesuai tinggi navbar */
        }

        /* Navbar custom */
        .custom-navbar {
            background: linear-gradient(135deg, #7f00ff, #e100ff, #00c6ff);
            padding: 0.5rem 1rem;   /* lebih ramping */
            min-height: 56px;       /* default tinggi bootstrap */
        }
        .custom-navbar .navbar-brand {
            font-size: 1rem;
            font-weight: 600;
            color: #fff !important;
        }
        .custom-navbar .nav-link,
        .custom-navbar .btn-link {
            font-size: 0.95rem;
            padding: 0.5rem 0.75rem;
            color: #fff !important;
            font-weight: 500;
            transition: color 0.2s;
        }
        .custom-navbar .nav-link:hover,
        .custom-navbar .btn-link:hover {
            color: #ffe6fc !important;
        }
        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }
        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Animasi fade */
        .container { animation: fadeIn 0.6s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* DataTables */
        table.dataTable thead th {
            background: #fff;
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">CruidInventaris</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"><i class="bi bi-list text-white"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      @auth
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('barang.index') }}">Barang</a></li>
        @if(auth()->user()->isSuper())
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.accounts.index') }}">Manage Accounts</a></li>
        @endif
        @if(auth()->user()->isSuper() || auth()->user()->isAdmin())
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.permissions.index') }}">Manajemen Permissions</a></li>
        @endif
        <li class="nav-item"><a class="nav-link" href="{{ route('barang.daftar') }}">Daftar Barang</a></li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link nav-link">Logout ({{ auth()->user()->name }})</button>
          </form>
        </li>
      </ul>
      @endauth
    </div>
  </div>
</nav>

<div class="container mt-4">
  @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // SweetAlert2 untuk session flash
    @if(session('success'))
      Swal.fire({ icon:'success', title:'Berhasil', text:"{{ session('success') }}", timer:2000, showConfirmButton:false });
    @endif
    @if(session('error'))
      Swal.fire({ icon:'error', title:'Oops!', text:"{{ session('error') }}" });
    @endif

    // DataTables global
    $(function(){
      $('table.datatable').DataTable({
        responsive:true,
        pageLength:7,
        language:{
          search:"🔍 Cari:", lengthMenu:"Tampilkan _MENU_ data",
          zeroRecords:"Tidak ada data ditemukan",
          info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",
          paginate:{previous:"‹", next:"›"}
        }
      });
    });

    // Konfirmasi delete
    $(document).on('click','.btn-delete',function(){
      let form=$(this).closest('form');
      Swal.fire({
        title:'Yakin hapus?', text:'Data yang dihapus tidak bisa dikembalikan!',
        icon:'warning', showCancelButton:true,
        confirmButtonColor:'#e100ff', cancelButtonColor:'#aaa',
        confirmButtonText:'Ya, hapus', cancelButtonText:'Batal'
      }).then((result)=>{ if(result.isConfirmed){ form.submit(); } });
    });
</script>
@stack('scripts')
</body>
</html>
