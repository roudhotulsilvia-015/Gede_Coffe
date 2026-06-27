@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Kasir GedeCoffee</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h5>Halo, {{ $user->name }}!</h5>
                    <p>Anda masuk sebagai <strong>{{ ucfirst($user->role) }}</strong>.</p>
                </div>
            </div>
        </div>
    </div>

    @if($user->role === 'admin')
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_karyawan'] }}</h3>
                        <p>Jumlah Karyawan</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ url('karyawan') }}" class="small-box-footer">Kelola Karyawan <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['total_produk'] }}</h3>
                        <p>Jumlah Produk</p>
                    </div>
                    <div class="icon"><i class="fas fa-coffee"></i></div>
                    <a href="{{ url('produk') }}" class="small-box-footer">Kelola Produk <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['total_transaksi'] }}</h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="icon"><i class="fas fa-history"></i></div>
                    <a href="{{ route('transaksi.riwayat') }}" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['total_transaksi'] }}</h3>
                        <p>Transaksi Anda</p>
                    </div>
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    <a href="{{ url('kasir') }}" class="small-box-footer">Mulai Kasir <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi</h3>
                    </div>
                    <div class="card-body">
                        <p>Gunakan menu Kasir untuk memproses transaksi dan lihat riwayat transaksi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop