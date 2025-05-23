@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Edit User</h2>
    <form action="{{ route('admin.update', $users->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{ $users->nik }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lenkap</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $users->name }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="usernama" name="username" value="{{ $users->username }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="validator" {{ $users->role == 'validator' ? 'selected' : '' }}>Validator</option>
                <option value="karyawan" {{ $users->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jabatan_id" class="form-label">Jabatan</label>
            <select class="form-control" id="jabatan_id" name="jabatan_id">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jabatans as $jabatan)
                    <option value="{{ $jabatan->jabatan_id }}" {{ $users->jabatan_id == $jabatan->jabatan_id ? 'selected' : '' }}>
                        {{ $jabatan->nama_jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit</label>
            <select class="form-control" id="unit_id" name="unit_id">
                <option value="">-- Pilih Unit --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->unit_id }}" {{ $users->unit_id == $unit->unit_id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.table') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection