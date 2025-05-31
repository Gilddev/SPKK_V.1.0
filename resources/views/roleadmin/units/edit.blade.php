@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Edit Unit</h2>
    <form action="{{ route('admin.unit_update', $units->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Kode Unit -->
        <div class="mb-3">
            <label for="kode_unit" class="form-label">Kode Unit</label><br>
            <small>Buat kode unit maximal 3 karakter dengan huruf kapital.</small>
            <input type="text" class="form-control" name="kode_unit" value="{{ $units->kode_unit }}" required>
        </div>

        <!-- Nama Unit -->
        <div class="mb-3">
            <label for="nama_unit" class="form-label">Nama Unit</label>
            <input type="text" class="form-control" name="nama_unit" value="{{ $units->nama_unit }}" required>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Clear</button>
            <a href="{{ route('admin.unit_index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>
@endsection