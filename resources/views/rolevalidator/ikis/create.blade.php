@extends('layouts.validator')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tambah Indikator Kinerja Individu</h2>
    
    <form action="{{ route('validator.iki_store') }}" method="POST">
        @csrf

        {{-- <div class="mb-3">
            <label for="kode_iki" class="form-label">Kode Iki</label>
            <input type="text" class="form-control" name="kode_iki">
        </div> --}}
        <p>Kode IKI akan dibuat otomatis oleh sistem.</p>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit Kerja</label>
            <select name="unit_id" class="form-control" required>
                <option value="">Pilih Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi_indikator" class="form-label">Deskripsi Indikator Kinerja Individu</label>
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
        <a href="{{ route('validator.iki_index') }}" class="btn btn-secondary">Kembali</a>
    </form>
    </form>
</div>
@endsection
