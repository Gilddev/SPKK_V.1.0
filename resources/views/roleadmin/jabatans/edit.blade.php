@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Edit Jabatan</h2>
    <form action="{{ route('admin.jabatan_update', $jabatans->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Jabatan -->
        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input type="text" class="form-control" name="nama_jabatan" value="{{ $jabatans->nama_jabatan }}" required>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Clear</button>
            <a href="{{ route('admin.jabatan_index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>
@endsection