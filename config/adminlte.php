<?php

return [
    'title' => 'GedeCoffee Admin',
    'logo' => '<b>Gede</b>Coffee',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    
    // Layout
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,

    // URLs
    'dashboard_url' => 'dashboard',
    'use_route_url' => true,
    'logout_url' => 'logout',
    'logout_method' => 'POST',
    'login_url' => 'login',
    'register_url' => false,

    // Menu Sidebar (INI BAGIAN PENTING)
    'menu' => [
        ['header' => 'MENU UTAMA'],
        [
            'text' => 'Dashboard',
            'url'  => 'dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],
        [
            'text' => 'Data Karyawan',
            'url'  => 'karyawan',
            'icon' => 'fas fa-fw fa-users',
            'can'  => 'admin',
        ],
        [
            'text' => 'Manajemen User',
            'url'  => 'users',
            'icon' => 'fas fa-fw fa-user-cog',
            'can'  => 'admin',
        ],
        // 'Sesi Aktif' menu removed per request
        [
            'text' => 'Menu Produk',
            'url'  => 'produk',
            'icon' => 'fas fa-fw fa-coffee',
            'can'  => 'admin',
        ],
        ['header' => 'TRANSAKSI'],
        [
            'text' => 'Kasir',
            'url'  => 'kasir',
            'icon' => 'fas fa-cash-register',
            'can'  => ['admin', 'kasir'],
        ],
        [
            'text' => 'Riwayat Transaksi',
            'url'  => 'riwayat-transaksi',
            'icon' => 'fas fa-fw fa-history',
            'can'  => ['admin', 'kasir'],
        ],
        [
            'text' => 'Laporan Bulanan',
            'url'  => 'laporan-transaksi',
            'icon' => 'fas fa-fw fa-chart-line',
            'can'  => ['admin', 'kasir'],
        ],
        ['header' => 'AKUN'],
        [
            'text' => 'Logout',
            'route' => 'logout.get',
            'icon' => 'fas fa-fw fa-sign-out-alt',
        ],
    ],

    // Plugins
    'plugins' => [
        'Datatables' => ['active' => true, 'files' => [['type' => 'js', 'asset' => true, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js']]],
        'Sweetalert2' => ['active' => true, 'files' => [['type' => 'js', 'asset' => false, 'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8']]],
    ],
];