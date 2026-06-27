@extends('adminlte::page')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Laporan Bulanan</h3>
        <form method="GET" action="{{ route('transaksi.report') }}" class="form-inline">
            <div class="input-group">
                <select name="year" class="form-control">
                    @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button class="btn btn-primary">Tampilkan</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Grafik Pendapatan per Bulan</div>
                    <div class="card-body">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Ringkasan Tahun {{ $year }}</div>
                    <div class="card-body">
                        <p><strong>Total Transaksi:</strong> {{ $totalTransactions }}</p>
                        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Detail Laporan Bulanan</div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="tableReport">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tableData as $row)
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
