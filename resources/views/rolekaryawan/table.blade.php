@extends('layouts.karyawan')

@section('content')
<div class="container mt-3 mb-3">
    
    <h2>Indikator Penilaian Unit {{ Auth::user()->unit->nama_unit }}</h2>
    <h4>Indikator Penilaian Individu</h4>

        <table class="table table-bordered">
            <thead>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Indikator Keberhasilan</th>
                <th>Parameter</th>
            </thead>
            <tbody>
                @foreach($indikatorsIki as $d)
                    <tr>
                        <td>{{ $d->kode_iki }}</td>
                        <td>{{ $d->deskripsi_indikator }}</td>
                        <td>{{ $d->indikator_keberhasilan }}</td>
                        <td>{{ $d->parameter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    <h4>Indikator Penilaian Umum</h4>

        <table class="table table-bordered">
            <thead>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Indikator Keberhasilan</th>
                <th>Parameter</th>
            </thead>
            <tbody>
                @foreach($indikatorsIku as $d)
                    <tr>
                        <td>{{ $d->kode_iku }}</td>
                        <td>{{ $d->deskripsi_indikator }}</td>
                        <td>{{ $d->indikator_keberhasilan }}</td>
                        <td>{{ $d->parameter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection