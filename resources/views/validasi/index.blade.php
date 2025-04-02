@extends('layouts.validator')

@section('content')
<div class="container">
    <h2 class="mb-4">Validasi Hasil Unggahan Karyawan</h2>

    <!-- Daftar Karyawan -->
    <div class="card mb-4">
        <div class="card-header">Pilih Karyawan</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawan as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a href="{{ route('validasi.show', $user->id) }}" class="btn btn-primary btn-sm">
                                Lihat Uploadan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection