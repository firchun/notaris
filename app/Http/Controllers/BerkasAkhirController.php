<?php

namespace App\Http\Controllers;

use App\Models\BerkasAkhir;
use App\Models\Notifikasi;
use App\Models\Pelayanan;
use App\Models\PelayananStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BerkasAkhirController extends Controller
{
    public function uploadBerkas(Request $request)
    {
        $id_pelayanan = $request->input('id_pelayanan');
        $file = $request->file('berkas_akhir');
        if ($request->hasFile('berkas_akhir')) {
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $file_path_berkas = $file->storeAs('public/berkas_akhir', $filename);
        } else {
            return response()->json(['message' => 'Harap isi berkas yang ingin di upload']);
        }

        $upload_berkas = new BerkasAkhir();
        $upload_berkas->id_pelayanan = $id_pelayanan;
        $upload_berkas->id_staff = Auth::id();
        $upload_berkas->berkas_akhir = $file_path_berkas;
        $upload_berkas->save();
        return response()->json(['message' => 'Berhasil upload berkas akhir']);
    }
    public function terimaBerkas(Request $request)
    {
        $id_pelayanan = $request->input('id_pelayanan');
        $file = $request->file('foto');
        if ($request->hasFile('foto')) {
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $file_path_berkas = $file->storeAs('public/penerimaan', $filename);
        } else {
            return response()->json(['message' => 'Harap isi foto penerimaan']);
        }

        $upload_berkas = BerkasAkhir::where('id_pelayanan', $id_pelayanan)->first();
        $upload_berkas->foto_penerimaan = $file_path_berkas;
        $upload_berkas->diterima = 1;
        $upload_berkas->save();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id_pelayanan;
        $status->status = 'Berkas telah diserahkan';
        $status->save();

        //notifikasi 
        $pelayanan = Pelayanan::find($id_pelayanan);
        $admin = User::where('role', 'Admin')->get();
        foreach ($admin as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Berkas pada no. dokumen ' . $pelayanan->no_dokumen . ' oleh : ' . $pelayanan->pemohon->name . ', telah diserahkan..';
            $notifikasi->jenis = 'primary';
            $notifikasi->url = '/report/pelayanan';
            $notifikasi->save();
        }

        return response()->json(['message' => 'Berhasil update penerimaan']);
    }
    public function getBerkasAkhir($id_pelayanan)
    {
        $berkas_akhir = BerkasAkhir::where('id_pelayanan', $id_pelayanan)->latest()->first();
        return response()->json($berkas_akhir);
    }
}
