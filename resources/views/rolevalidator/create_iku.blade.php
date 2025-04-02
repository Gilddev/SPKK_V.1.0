@extends('layouts.validator')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tambah Indikator Kinerja Utama</h2>
    
    <form action="{{ route('validator.store_Iku') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="deskripsi_indikator" class="form-label">Deskripsi Indikator Kinerja Utama</label>
            <textarea class="form-control" name="deskripsi_indikator" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="indikator_keberhasilan" class="form-label">Indikator Keberhasilan</label>
            <input type="text" class="form-control" name="indikator_keberhasilan" required>
        </div>

        <div class="mb-3">
            <label for="parameter" class="form-label">Parameter</label>
            <input type="text" class="form-control" name="parameter" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection