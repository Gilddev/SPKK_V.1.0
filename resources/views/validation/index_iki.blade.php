@extends('layouts.validator')

@section('content')
<div class="container mt-3">
    <h2>Penilaian Indikator Kinerja Individu</h2>
    {{-- <table class="table table-bordered">
        <thead>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Unit</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @foreach ($dataKaryawan as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->jabatan->nama_jabatan }}</td>
                <td>{{ $d->unit->nama_unit }}</td>
                <td>
                    <a href="#" class="btn btn-primary">Nilai</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
    <table class="table table-bordered">
        <thead>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Unit</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @foreach ($dataKaryawan as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->jabatan->nama_jabatan }}</td>
                <td>{{ $d->unit->nama_unit }}</td>
                <td>
                    @if ($d->uploadIki->count() > 0)
                        <a href="{{ route('validation.show_iki', $d->id) }}" class="btn btn-primary">Nilai</a>
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