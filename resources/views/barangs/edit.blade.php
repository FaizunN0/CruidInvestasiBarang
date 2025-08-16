  {{-- jika ada yang salah atau eror atau yang lain maka iti fitur bukan bug 😅 --}}
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white d-flex align-items-center">
                    <i class="bi bi-pencil-square fs-4 me-2"></i>
                    <h5 class="mb-0"> Edit Data Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('barangs.update', $barang) }}" method="POST">
                        @csrf @method('PUT')
                        @include('barangs._form', ['buttonText' => '🔄 Update'])
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
                title: 'Berhasil Diubah!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Kembali',
                customClass: {
                    confirmButton: 'btn btn-warning'
                },
                buttonsStyling: false
            });
        </script>
    @endif
@endpush
