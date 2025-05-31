@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tambah Unit Baru</h2>
    <form action="{{ route('admin.unit_store') }}" method="POST">
        @csrf

        <!-- Kode Unit -->
        <div class="mb-3">
            <label for="kode_unit" class="form-label">Kode Unit</label><br>
            <small>Buat kode unit maximal 3 karakter dengan huruf kapital.</small>
            <input type="text" class="form-control" name="kode_unit" required>
        </div>

        <!-- Nama Unit -->
        <div class="mb-3">
            <label for="nama_unit" class="form-label">Nama Unit</label>
            <input type="text" class="form-control" name="nama_unit" required>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Clear</button>
            <a href="{{ route('admin.unit_index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>
@endsection