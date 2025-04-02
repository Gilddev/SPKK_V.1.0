@extends('layouts.validator')

@section('content')
<div class="container mt-3">
    <h2>Penilaian Indikator Kinerja Utama</h2>
    <table class="table table-bordered">
        <thead>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @foreach ($dataKaryawan as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->jabatan->nama_jabatan }}</td>
                <td>
                    @if ($d->uploadIku->count() > 0)
                        <a href="{{ route('validation.show_iku', $d->id) }}" class="btn btn-primary">Nilai</a>
                    @else
                        <span class="text-muted">Belum ada Inputan</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection