<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function readAll()
    {
        $notifikasi = Notifikasi::where('dibaca', 0);
        $notifikasi->dibaca = 1;
        $notifikasi->save();

        session()->flash('success', 'semua notifikasi telah dibaca');
        return back();
    }
    public function readOne($id)
    {
        $notifikasi = Notifikasi::find($id);
        $notifikasi->dibaca = 1;
        $notifikasi->save();

        return redirect()->to($notifikasi->url);
    }
}
