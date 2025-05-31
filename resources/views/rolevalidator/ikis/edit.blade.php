@extends('layouts.validator')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Edit Indikator Kinerja Individu</h2>
    
    <form action="{{ route('validator.iki_update', $indikators->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode_iki" class="form-label">Kode Iki</label>
            <input type="text" class="form-control" name="kode_iki" value="{{$indikators->kode_iki}}" required disabled>
        </div>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit</label>
            <select name="unit_id" class="form-control" required disabled>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ $indikators->unit_id == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi_indikator" class="form-label">Deskripsi Indikator Kinerja Individu</label>
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
        <a href="{{ route('validator.iki_index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
