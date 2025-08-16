  {{-- jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅 --}}
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill fs-4 me-2"></i>
                    <h5 class="mb-0"> Tambah Data Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('barangs.store') }}" method="POST">
                        @csrf
                        @include('barangs._form', ['buttonText' => '➕ Simpan'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil Ditambahkan!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Mantap! 🎉',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        </script>
    @endif
@endpush
