@extends('adminlte::page')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="card">
    // Menampilkan header laporan bulanan dengan pilihan tahun
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Laporan Bulanan</h3>
        <form method="GET" action="{{ route('transaksi.report') }}" class="form-inline">
            <div class="input-group">
                <select name="year" class="form-control">
                    // Menampilkan pilihan tahun dari 2 tahun yang lalu hingga 1 tahun ke depan
                    @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                // Tombol untuk menampilkan laporan berdasarkan tahun yang dipilih
                <button class="btn btn-primary">Tampilkan</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    // Menampilkan grafik pendapatan per bulan
                    <div class="card-header">Grafik Pendapatan per Bulan</div>
                    <div class="card-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    // Menampilkan ringkasan total transaksi dan pendapatan
                    <div class="card-header">Ringkasan Tahun {{ $year }}</div>
                    <div class="card-body">
                    // Menampilkan total transaksi dan total pendapatan
                        <p><strong>Total Transaksi:</strong> {{ $totalTransactions }}</p>
                        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Detail Laporan Bulanan</div>
            <div class="card-body">
                // Menampilkan tabel laporan bulanan dengan jumlah transaksi dan total pendapatan per bulan 
                <table class="table table-striped table-bordered" id="tableReport">
                    <thead>
                        // Menampilkan header tabel laporan bulanan
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tableData as $row)
                        // Menampilkan data bulan, jumlah transaksi, dan total pendapatan
                            <tr>
                                <td>{{ $row['month'] }}</td>
                                <td>{{ $row['count'] }}</td>
                                <td>Rp {{ number_format($row['total_revenue']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mengambil data label dan data dari controller untuk grafik
    const labels = @json($chartLabels);
    const data = {
        labels: labels,
        datasets: [{
            label: 'Pendapatan',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            data: @json($chartData),
            fill: true,
            tension: 0.3,
        }]
    };
// Mengatur konfigurasi grafik
    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    };
    
    new Chart(document.getElementById('monthlyChart'), config);
</script>
@stop
