@extends('layouts.validator')

@section('content')
<div class="container mt-3 mb-3">

    <div class="row">
        <div class="col">
            <h3>Tabel Indikator Kinerja Individu</h3>
        </div>
        <div class="col text-end">
                <a href="{{ route('validator.iki_create') }}" class="btn btn-primary btn-sm">Tambah Indikator</a>
        </div>
    </div>

    <div>
        @foreach ($indikators->groupBy('unit.nama_unit') as $unit => $indikatorUnit)
            <h3>{{ $unit }}</h3> {{-- Menampilkan nama unit sebagai header --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Indikator Penilaian</th>
                        <th>Indikator Keberhasilan</th>
                        <th>Parameter</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indikatorUnit as $d)
                        <tr>
                            <td>{{ $d->kode_iki }}</td>
                            <td>{{ $d->deskripsi_indikator }}</td>
                            <td>{{ $d->indikator_keberhasilan }}</td>
                            <td>{{ $d->parameter }}</td>
                            <td>
                                <a href="{{ route('validator.iki_edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $d->id }})">Hapus</button>
                                <form id="delete-form-{{ $d->id }}" action="{{ route('validator.iki_delete', $d->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
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