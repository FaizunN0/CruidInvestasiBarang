{{-- resources/views/admin/permissions/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-white d-flex align-items-center justify-content-between"
                 style="background: linear-gradient(135deg, #7f00ff, #e100ff, #00c6ff);">
                <h5 class="mb-0">
                    <i class="bi bi-sliders me-2"></i> Atur Permissions untuk <strong>{{ $user->name }}</strong>
                </h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.permissions.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="row">
                            @foreach($permissions as $perm)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               name="permissions[]" value="{{ $perm->id }}"
                                               id="perm{{ $perm->id }}"
                                               {{ $user->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm{{ $perm->id }}">
                                            {{ $perm->label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // SweetAlert2 untuk notifikasi sukses
    @if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#7f00ff',
        showClass: { popup: 'animate__animated animate__zoomIn' },
        hideClass: { popup: 'animate__animated animate__fadeOut' }
    });
    @endif

    // SweetAlert2 untuk notifikasi error
    @if($errors->any())
    Swal.fire({
        title: 'Gagal!',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        icon: 'error',
        confirmButtonColor: '#e100ff',
        showClass: { popup: 'animate__animated animate__shakeX' },
        hideClass: { popup: 'animate__animated animate__fadeOut' }
    });
    @endif
});
</script>
@endpush
