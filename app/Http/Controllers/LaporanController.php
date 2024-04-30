<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pelayanan()
    {
        $data = [
            'title' => 'Laporan Pengajuan Layanan'
        ];
        return view('admin.laporan.pelayanan', $data);
    }
    public function pembayaran()
    {
        $data = [
            'title' => 'Laporan Pembayaran'
        ];
        return view('admin.laporan.pembayaran', $data);
    }
}
