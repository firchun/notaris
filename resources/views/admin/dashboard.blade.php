@extends('layouts.backend.admin')

@section('content')
    <div class="row justify-content-center">
        @include('admin.dashboard_component.card1', [
            'count' => $users,
            'title' => 'Pemohon',
            'subtitle' => 'Total Pemohon terdaftar',
            'color' => 'primary',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $staff,
            'title' => 'Staff',
            'subtitle' => 'Total Staff',
            'color' => 'warning',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $keuangan,
            'title' => 'Staff Keuangan',
            'subtitle' => 'Total Staff Keuangan',
            'color' => 'danger',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $layanan,
            'title' => 'Layanan',
            'subtitle' => 'Total Layanan',
            'color' => 'success',
            'icon' => 'folder',
        ])
    </div>
    <hr>
    <h3 class="text-center">Pengajuan Layanan</h3>
    <div class="row justify-content-center">
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan,
            'title' => 'Pengajuan',
            'subtitle' => 'Total Pengajuan Masuk',
            'color' => 'success',
            'icon' => 'folder',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_new,
            'title' => 'Pengajuan Baru',
            'subtitle' => 'Total Pengajuan Baru',
            'color' => 'warning',
            'icon' => 'log-in',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_verified,
            'title' => 'Pengajuan Terverifikasi',
            'subtitle' => 'Total Pengajuan Terverifikasi/diterima oleh staff',
            'color' => 'primary',
            'icon' => 'check-circle',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_not_confirm,
            'title' => 'Pengajuan Menunggu konfirmasi',
            'subtitle' => 'Total Pengajuan menunggu konfirmasi oleh pemohon',
            'color' => 'warning',
            'icon' => 'revision',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_confirm,
            'title' => 'Pengajuan ter-konfirmasi',
            'subtitle' => 'Total Pengajuan ter-konfirmasi oleh pemohon',
            'color' => 'success',
            'icon' => 'check-circle',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_not_lunas,
            'title' => 'Pengajuan Menunggu Pembayaran',
            'subtitle' => 'Total Pengajuan menunggu pembayaran oleh pemohon',
            'color' => 'danger',
            'icon' => 'wallet',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_lunas,
            'title' => 'Pengajuan Lunas',
            'subtitle' => 'Total Pengajuan Lunas',
            'color' => 'success',
            'icon' => 'wallet',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $total_pengajuan_send,
            'title' => 'Pengajuan Diserahkan',
            'subtitle' => 'Total Pengajuan yang telah diserahkan oleh staff',
            'color' => 'primary',
            'icon' => 'send',
        ])
    </div>
@endsection
