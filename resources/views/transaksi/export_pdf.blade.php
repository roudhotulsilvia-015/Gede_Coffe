<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .heading { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2 class="heading">Laporan Transaksi</h2>
    <table>
        <thead> 
            <tr>
                <th>Kode Transaksi</th>
                <th>Kasir</th>
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
                <td>{{ optional($t->user)->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($t->total_harga) }}</td>
                <td class="text-right">Rp {{ number_format($t->bayar) }}</td>
                <td class="text-right">Rp {{ number_format($t->kembalian) }}</td>
                <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>