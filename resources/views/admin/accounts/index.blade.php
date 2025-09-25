@extends('layouts.app')

@section('content')
<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-people"></i> Manage Accounts</h5>
    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Akun</a>
  </div>
  <div class="card-body">
    <div class="table-wrapper">
      <table class="table datatable">
        <thead>
          <tr>
            <th>Nama</th><th>Email</th><th>Role</th><th>Permissions</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($accounts as $acc)
            <tr>
              <td>{{ $acc->name }}</td>
              <td>{{ $acc->email }}</td>
              <td>{{ ucfirst($acc->role) }}</td>
              <td>
                @foreach($acc->permissions as $perm)
                  <span class="badge bg-info">{{ $perm->name }}</span>
                @endforeach
              </td>
              <td>
                <a href="{{ route('admin.accounts.edit',$acc) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                <a href="{{ route('admin.permissions.edit',$acc) }}" class="btn btn-secondary btn-sm"><i class="bi bi-shield-lock"></i></a>
                <form action="{{ route('admin.accounts.destroy',$acc) }}" method="POST" class="d-inline delete-form">
                  @csrf @method('DELETE')
                  <button type="button" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
