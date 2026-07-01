@extends('adminlte::page')

@section('content') 
    @yield('main_content') 
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> 
    <div style="display:none;">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </div>
@stop

@section('js')
    @yield('additional_js')
@stop