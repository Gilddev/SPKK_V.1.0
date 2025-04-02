@extends('layouts.validator')

@section('content')
<div class="container">
    <h2 class="mb-4">Validasi Unggahan Karyawan: {{ $karyawan->name }}</h2>

    <!-- Indikator Kinerja Utama (IKU) -->
    <div class="card mb-4">
        <div class="card-header">Indikator Kinerja Utama (IKU)</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Unggahan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaian_iku as $iku)
                    <tr>
                        <td>{{ $iku->iku->deskripsi_indikator }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $iku->file) }}" target="_blank">Lihat File</a>
                        </td>
                        <td>
                            <form action="{{ route('validasi.update', $iku->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select">
                                    <option value="valid" {{ $iku->status == 'valid' ? 'selected' : '' }}>Valid</option>
                                    <option value="tidak valid" {{ $iku->status == 'tidak valid' ? 'selected' : '' }}>Tidak Valid</option>
                                </select>
                        </td>
                        <td>
                            <input type="text" name="catatan" class="form-control" value="{{ $iku->catatan }}">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Indikator Kinerja Individu (IKI) -->
    <div class="card">
        <div class="card-header">Indikator Kinerja Individu (IKI)</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Unggahan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaian_iki as $iki)
                    <tr>
                        <td>{{ $iki->iki->deskripsi_indikator }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $iki->file) }}" target="_blank">Lihat File</a>
                        </td>
                        <td>
                            <form action="{{ route('validasi.update', $iki->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select">
                                    <option value="valid" {{ $iki->status == 'valid' ? 'selected' : '' }}>Valid</option>
                                    <option value="tidak valid" {{ $iki->status == 'tidak valid' ? 'selected' : '' }}>Tidak Valid</option>
                                </select>
                        </td>
                        <td>
                            <input type="text" name="catatan" class="form-control" value="{{ $iki->catatan }}">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
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
