@extends('layouts.karyawan')

@section('content')
<div class="container mt-3 mb-3">
    <h2>Indikator Penilaian Unit {{ Auth::user()->unit->nama_unit }}</h2>
    <ul class="list-group">
        @foreach($indikators as $d)
            <li class="list-group-item">
                {{ $d->deskripsi_indikator }}
            </li>
        @endforeach
    </ul>
</div>
@endsection