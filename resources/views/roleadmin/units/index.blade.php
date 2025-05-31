@extends('layouts.admin')

@section('content')
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col">
            <h3>Tabel Unit</h3>
        </div>
    <div class="col text-end">
            <a href="{{ route('admin.unit_create') }}" class="btn btn-primary btn-sm">Tambah Unit</a>
    </div>
    </div>

    <div> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Unit</th>
                    <th>Nama Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $units as $d )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->kode_unit }}</td>
                    <td>{{ $d->nama_unit }}</td>
                    <td>
                        <a href="{{ route('admin.unit_edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $d->id }})">Hapus</button>
                        <form id="delete-form-{{ $d->id }}" action="{{ route('admin.unit_delete', $d->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <script>
        function confirmDelete(unitId) {
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
                    document.getElementById('delete-form-' + unitId).submit();
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