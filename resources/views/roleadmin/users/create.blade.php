@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Tambah User Baru</h2>
    <form action="{{ route('admin.user_store') }}" method="POST">
        @csrf

        <!-- Nik -->
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="number" class="form-control" name="nik" required>
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <!--  Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="validator">Validator</option>
                <option value="karyawan">Karyawan</option>
            </select>
        </div>

        <!-- Unit -->
        <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="unit_id" class="form-control" required>
                <option value="">Pilih Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
        </div>

        <!-- Jabatan -->
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="jabatan_id" class="form-control" required>
                <option value="">Pilih Jabatan</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Clear</button>
            <a href="{{ route('admin.user_index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>
@endsection