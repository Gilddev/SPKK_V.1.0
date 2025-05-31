@extends('layouts.validator')

@section('content')
<div class="container">
    <div class="mt-3 m-3 text-center">Selamat datang di halaman validator. Pilih menu di navbar untuk mengelola sistem.</div>
</div>
<div class="container">
    <h3 class="text-center">Grafik Kinerja Karyawan</h3>

    <div class="row mt-4">
        <!-- Grafik Total Karyawan & Validator -->
        <div class="col-md-4">
            <h5 class="text-center">Total User</h5>
            <canvas id="totalUserChart"></canvas>
        </div>

        <!-- Grafik Top 5 Karyawan -->
        <div class="col-md-4">
            <h5 class="text-center">Top 5 Karyawan</h5>
            <canvas id="top5KaryawanChart"></canvas>
        </div>

        <!-- Grafik Bottom 5 Karyawan -->
        <div class="col-md-4">
            <h5 class="text-center">Bottom 5 Karyawan</h5>
            <canvas id="bottom5KaryawanChart"></canvas>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Total Karyawan dan validator
        let totalKaryawan = {{ $totalKaryawan }};
        let totalValidator = {{ $totalValidator }};

        // Inisialisasi Grafik Total User
        var ctx1 = document.getElementById('totalUserChart').getContext('2d');
        var totalUserChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Karyawan', 'Validator'],
                datasets: [{
                    label: 'Jumlah Per Role',
                    data: [totalKaryawan, totalValidator],
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart Top 5 Karyawan
        var ctx2 = document.getElementById('top5KaryawanChart').getContext('2d');
        var top5KaryawanChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($top5Karyawan->pluck('name')) !!},
                datasets: [{
                    label: 'Persentase Kinerja (%)',
                    data: {!! json_encode($top5Karyawan->pluck('persentase_kinerja')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, max: 100 }
                }
            }
        });

        // Chart Bottom 5 Karyawan
        var ctx3 = document.getElementById('bottom5KaryawanChart').getContext('2d');
        var bottom5KaryawanChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bottom5Karyawan->pluck('name')) !!},
                datasets: [{
                    label: 'Persentase Kinerja (%)',
                    data: {!! json_encode($bottom5Karyawan->pluck('persentase_kinerja')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, max: 100 }
                }
            }
        });
    </script>
@endsection