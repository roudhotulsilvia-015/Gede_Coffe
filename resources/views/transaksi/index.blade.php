@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Transaksi</h3>
        <div class="card-tools">
            <a href="{{ route('transaksi.export.pdf') }}" class="btn btn-danger btn-sm mr-1">Export PDF</a>
            <a href="{{ route('transaksi.export.excel') }}" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="tabelTransaksi">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Total Harga</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $t)
                <tr>
                    <td>{{ $t->kode_transaksi }}</td>
                    <td>Rp {{ number_format($t->total_harga) }}</td>
                    <td>Rp {{ number_format($t->bayar) }}</td>
                    <td>Rp {{ number_format($t->kembalian) }}</td>
                    <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#tabelTransaksi').DataTable({
            responsive: true,
            pageLength: 10,
        });
    });
</script>
@stop