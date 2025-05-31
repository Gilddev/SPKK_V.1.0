@extends('layouts.validator')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tambah Indikator Kinerja Utama</h2>
    
    <form action="{{ route('validator.iku_store') }}" method="POST">
        @csrf

        {{-- <div class="mb-3">
            <label for="kode_iku" class="form-label">Kode Iku</label>
            <input type="text" class="form-control" name="kode_iku">
        </div> --}}
        <p>Kode IKU akan dibuat otomatis oleh sistem.</p>

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

        <div class="mb-3">
            <label for="berulang" class="form-label">Berulang</label><br>
            <select name="berulang" class="form-control" required>
                <option value=""> - </option>
                <option value="ya">Iya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('validator.iku_index') }}" class="btn btn-primary">Kembali</a>
    </form>
</div>
@endsection