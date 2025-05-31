@extends('layouts.admin')

@section('content')
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col">
            <h3>Tabel User</h3>
        </div>
    <div class="col text-end">
            <a href="{{ route('admin.user_create') }}" class="btn btn-primary btn-sm">Tambah User</a>
    </div>
    </div>

    <div> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama Lengkap</th>
                    <th>Userame</th>
                    <th>Role</th>
                    <th>Jabatan</th>
                    <th>Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $users as $key => $d )
                <tr>
                    {{-- <td>{{ $loop->iteration }}</td> --}}
                    <td>{{ $users->firstItem() + $key }}</td>
                    <td>{{ $d->nik }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->role }}</td>
                    <td>{{ $d->jabatan->nama_jabatan }}</td>
                    <td>{{ $d->unit->nama_unit }}</td>
                    <td>
                        <a href="{{ route('admin.user_edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $d->id }})">Hapus</button>
                        <form id="delete-form-{{ $d->id }}" action="{{ route('admin.user_delete', $d->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tampilkan link pagination --}}
        <div class="d-flex justify-content-end small">
            {{ $users->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                    Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                    timer: 6000
                    });
                }
            });
        }
    </script>
@endsection