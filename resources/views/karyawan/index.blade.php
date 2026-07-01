@extends('adminlte::page')

@section('content') 
<div class="card"> 
    <div class="card-header">
        <h3 class="card-title">Daftar Karyawan</h3>
        <div class="card-tools">
            <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">Tambah Karyawan</a>
        </div>
    </div> 
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div> 
        @endif
        <table class="table table-bordered table-striped" id="tabelKaryawan"> 
            <thead> 
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead> 
            <tbody>
                @foreach($karyawans as $k)
                <tr>
                    <td>{{ $k->id }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->jabatan }}</td>
                    <td>{{ $k->telepon }}</td>
                    <td>
                        <a href="{{ route('karyawan.show', $k->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('karyawan.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop 
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop 
@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabelKaryawan').DataTable({
            responsive: true,
            pageLength: 10,
        });
    });
</script>
@stop