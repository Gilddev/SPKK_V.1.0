@extends('layouts.validator')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Edit Indikator Kinerja Utama</h2>
    
    <form action="{{ route('validator.update_Iku', $indikators->iku_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="deskripsi_indikator" class="form-label">Deskripsi Indikator Kinerja Utama</label>
            <textarea class="form-control" name="deskripsi_indikator" rows="5" required>{{ old('deskripsi_indikator', $indikators->deskripsi_indikator) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="indikator_keberhasilan" class="form-label">Deskripsi Indikator</label>
            <input type="text" class="form-control" name="indikator_keberhasilan" value="{{ old('indikator_keberhasilan', $indikators->indikator_keberhasilan) }}" required>
        </div>

        <div class="mb-3">
            <label for="parameter" class="form-label">Deskripsi Indikator</label>
            <input type="text" class="form-control" name="parameter" value="{{ old('parameter', $indikators->parameter) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('validator.table_Iku') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
