<!DOCTYPE html>
<html lang="en">
  {{-- jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅 --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CruidInvestasiBarang</title>

    {{--  Fonts family Poppins  --}}
    <link href="https://fonts.gofamiogleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    {{-- boostrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- data tabel --}}
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    {{-- SweetAlert2 ben koyo web pemerintah --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    {{-- Bootstrap Icons sing gratis gratis ae --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            /* lah ? */
            font-family: 'Poppins', sans-serif;
            /* ??? */
            background: linear-gradient(135deg, #7f00ff 0%, #e100ff 50%, #00c6ff 100%);
            color: #2b2b2b;
            padding: 2rem 0;
            min-height: 100vh;
        }

        /* Controls wrapper */
        .table-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            gap: 0.75rem;
        }

        .table-controls .dataTables_filter {
            margin: 0 !important;
        }

        .table-controls .dataTables_filter input {
            border: 2px solid #e6d5ff;
            border-radius: 0.5rem;
            padding: 0.375rem 0.75rem;
            min-width: 150px;
        }

        /* Scroll wrapper nggo tabel */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 0.75rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        /* werno scrool cedak datatabel ning ngesor */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: rgba(225, 0, 255, 0.2);
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #e100ff;
            border-radius: 4px;
        }

        .table-wrapper {
            scrollbar-width: thin;
            scrollbar-color: #e100ff rgba(225, 0, 255, 0.2);
        }

        /* Table styling */
        table.dataTable thead {
            background: #fff;
        }

        table.dataTable thead th {
            color: #222 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border: 1px solid #ddd;
            background: #fff;
            padding: 0.75rem;
        }

        table.dataTable tbody td {
            border: 1px solid #eee;
            padding: 0.75rem;
        }

        table.dataTable tbody tr:nth-child(odd) {
            background: #fff;
        }

        table.dataTable tbody tr:nth-child(even) {
            background: #fef7ff;
        }

        table.dataTable tbody tr:hover {
            background: #ffe6fc !important;
        }

        /* Pagination styling sing prev/next karo nomor halaman */
        .dataTables_wrapper .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            position: relative;
            z-index: 10;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #ffffffcc;
            color: #7f00ff !important;
            border: 2px solid #7f00ff;
            border-radius: 0.5rem;
            padding: 0.5em 0.75em;
            min-width: 2.5em;
            font-weight: 600;
            transition: all 0.15s;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #7f00ff, #e100ff);
            color: #fff !important;
            border-color: transparent;
            transform: translateY(-1px) scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: default;
        }

        /* Buttons & forms */
        .btn-primary {
            background: #e100ff;
            border-color: #e100ff;
        }

        .btn-primary:hover {
            background: #cc00dd;
            border-color: #cc00dd;
        }

        .btn-warning {
            background: #ffb300;
            border-color: #ffb300;
            color: #fff;
        }

        .btn-danger {
            background: #ff4d4d;
            border-color: #ff4d4d;
            color: #fff;
        }

        .form-control:focus {
            border-color: #e100ff;
            box-shadow: 0 0 0 0.2rem rgba(225, 0, 255, 0.2);
        }

        .swal2-popup {
            border-radius: 1rem;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- boostrap 5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- datatabel --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    {{-- swweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
