@extends('adminlte::page')

@section('content')
// Bagian utama dari halaman yang menampilkan konten yang berbeda tergantung pada halaman yang sedang diakses.
    @yield('main_content')
    // Form untuk logout dari sistem, menggunakan metode POST untuk keamanan.
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
// Link untuk logout yang tersembunyi, akan memicu form logout saat diklik.
    <div style="display:none;">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </div>
@stop

@section('js')
    @yield('additional_js')
@stop