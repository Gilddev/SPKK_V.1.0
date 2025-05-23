@extends('layouts.validator')

@section('content')
<div class="container mt-3 mb-3">

    <div class="row">
        <div class="col">
            <h3>Tabel Indikator Kinerja Utama</h3>
        </div>
        <div class="col text-end">
                <a href="{{ route('validator.create_Iku') }}" class="btn btn-primary btn-sm">Tambah Indikator</a>
        </div>
    </div>

    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Indikator Penilaian</th>
                    <th>Indikator Keberhasilan</th>
                    <th>Parameter</th>
                    <th>Berulang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indikators as $d)
                    <tr>
                        <td>{{ $d->deskripsi_indikator }}</td>
                        <td>{{ $d->indikator_keberhasilan }}</td>
                        <td>{{ $d->parameter }}</td>
                        <td>{{ $d->berulang }}</td>
                        <td>
                            <a href="{{ route('validator.edit_Iku', $d->iku_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $d->iku_id }})">Hapus</button>
                            <form id="delete-form-{{ $d->iku_id }}" action="{{ route('validator.destroy_Iku', $d->iku_id) }}" method="POST" style="display: none;">
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