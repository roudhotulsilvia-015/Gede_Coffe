@extends('adminlte::page')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop 
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Menu Produk</h3>
        <div class="card-tools"><a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">Tambah</a></div>
    </div> 
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-striped" id="tabelProduk"> 
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $p) 
                <tr>
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ $p->kategori }}</td>
                    <td>Rp {{ number_format($p->harga) }}</td>
                    <td>{{ $p->stok }}</td>
                    <td> 
                        <a href="{{ route('produk.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    // Script untuk mengaktifkan fitur DataTables pada tabel daftar produk, termasuk pengaturan responsif, jumlah entri per halaman, dan teks bahasa Indonesia.
    $(document).ready(function() {
        $('#tabelProduk').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ entri',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data tersedia',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Selanjutnya'
                }
            }
        });
    });
</script>
@stop