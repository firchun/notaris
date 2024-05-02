<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pelayanan()
    {
        $data = [
            'title' => 'Laporan Pengajuan Layanan',
            'layanan' => Layanan::all(),
        ];
        return view('admin.laporan.pelayanan', $data);
    }
    public function pembayaran()
    {
        $data = [
            'title' => 'Laporan Pembayaran',
            'layanan' => Layanan::all(),
            'user' => User::where('role', '!=', 'User')->get(),
        ];
        return view('admin.laporan.pembayaran', $data);
    }
    public function layanan()
    {
        $data = [
            'title' => 'Laporan Layanan',
        ];
        return view('admin.laporan.layanan', $data);
    }
}
