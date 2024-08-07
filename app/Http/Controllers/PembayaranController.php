<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pelayanan;
use App\Models\PelayananStatus;
use App\Models\PembayaranPelayanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function getPembayaranDataTable($id)
    {
        $pembayaran = PembayaranPelayanan::with(['pelayanan', 'staff'])->where('id_pelayanan', $id)->orderByDesc('id');

        return Datatables::of($pembayaran)
            ->addColumn('total', function ($pembayaran) {
                return 'Rp ' . number_format($pembayaran->total);
            })
            ->addColumn('foto', function ($pembayaran) {
                return '<a target="__blank" href="' . Storage::url($pembayaran->foto) . '"> <img src="' . Storage::url($pembayaran->foto) . '" style="width:50px;"></a>';
            })
            ->addColumn('action', function ($pembayaran) {
                return '<button class="btn btn-sm btn-danger" onclick="destroyPembayaran(' . $pembayaran->id . ')"><i class="bx bx-trash"></i></button>';
            })
            ->rawColumns(['total', 'action', 'foto'])
            ->make(true);
    }
    public function getAllPembayaranDataTable(Request $request)
    {
        $pembayaran = PembayaranPelayanan::with(['pelayanan' => function ($query) {
            $query->select('id', 'no_dokumen', 'id_layanan');
        }, 'pelayanan.layanan', 'staff'])->orderByDesc('id');

        if ($request->tanggal_awal != null || $request->tanggal_awal != '') {
            $pembayaran->where('created_at', '>=', $request->tanggal_awal)->where('created_at', '<=', $request->tanggal_akhir);
        }

        if ($request->layanan != null || $request->layanan != '') {
            $pembayaran->whereHas('pelayanan', function ($query) use ($request) {
                $query->where('id_layanan', $request->layanan);
            });
        }
        if ($request->staff != null || $request->staff != '') {
            $pembayaran->where('id_staff', $request->staff);
        }

        return Datatables::of($pembayaran)
            ->addColumn('total', function ($pembayaran) {
                return 'Rp ' . number_format($pembayaran->total);
            })
            ->addColumn('tanggal', function ($pembayaran) {
                return $pembayaran->created_at->format('d F Y');
            })

            ->addColumn('action', function ($pembayaran) {
                return '<button class="btn btn-sm btn-danger" onclick="destroyPembayaran(' . $pembayaran->id . ')"><i class="bx bx-trash"></i></button>';
            })
            ->rawColumns(['total', 'action', 'tanggal'])
            ->make(true);
    }
    public function store(Request $request)
    {
        if ($request->file('foto') == null || $request->file('foto') == '') {
            return response()->json(['message' => 'Harap upload foto bukti pembayaran']);
        }
        //pembayaran
        $pembayaran_old = PembayaranPelayanan::where('id_pelayanan', $request->input('id'))->sum('total');
        $pembayaran_new = $request->input('total');
        $total_pembayaran = $pembayaran_old + $pembayaran_new;
        //tagihan
        $tagihan = Pelayanan::find($request->input('id'));
        $total_tagihan = $tagihan->biaya;

        if ($total_pembayaran >= $total_tagihan) {
            $tagihan->is_paid = 1;
            $tagihan->save();

            $status = new PelayananStatus();
            $status->id_pelayanan = $request->input('id');
            $status->id_staff = Auth::user()->id;
            $status->status = 'Pembayaran LUNAS';
            $status->save();

            //notifikasi 
            $staff = User::where('role', 'Staff')->get();
            foreach ($staff as $item) {
                $notifikasi = new Notifikasi();
                $notifikasi->id_user = $item->id;
                $notifikasi->isi_notifikasi = 'Layanan ' . $tagihan->nama_layanan . ' oleh : ' . $tagihan->pemohon->name . ', telah lunas..';
                $notifikasi->jenis = 'primary';
                $notifikasi->url = '/pelayanan';
                $notifikasi->save();
            }
            session()->flash('success', 'Pembayaran telah lunas');
        }
        //foto pembayaran
        $foto = $request->file('foto');
        $filename_foto = Str::random(32) . '.' . $foto->getClientOriginalExtension();
        $file_path_foto = $foto->storeAs('public/berkas', $filename_foto);

        $pembayaran = new PembayaranPelayanan();
        $pembayaran->id_staff = Auth::id();
        $pembayaran->id_pelayanan = $request->input('id');
        $pembayaran->total = $request->input('total');
        $pembayaran->foto = $file_path_foto;
        $pembayaran->save();
        return response()->json(['message' => 'Berhasil menambah pembayaran']);
    }
    public function destroy($id)
    {
        $pembayaran = PembayaranPelayanan::find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran not found'], 404);
        }
        //pembayaran
        $pembayaran_old = PembayaranPelayanan::where('id_pelayanan', $pembayaran->id_pelayanan)->sum('total');
        $pembayaran_dihapus = $pembayaran->total;
        $total_pembayaran = $pembayaran_old - $pembayaran_dihapus;
        //tagihan
        $tagihan = Pelayanan::find($pembayaran->id_pelayanan);
        $total_tagihan = $tagihan->biaya;

        if ($total_pembayaran < $total_tagihan) {
            $tagihan->is_paid = 0;
            $tagihan->save();

            if ($total_pembayaran < $pembayaran_old) {
                $status = new PelayananStatus();
                $status->id_pelayanan = $pembayaran->id_pelayanan;
                $status->id_staff = Auth::user()->id;
                $status->status = 'Pelunasan digagalkan';
                $status->save();
                //notifikasi 
                $staff = User::where('role', 'Staff')->get();
                foreach ($staff as $item) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->id_user = $item->id;
                    $notifikasi->isi_notifikasi = 'Layanan ' . $tagihan->nama_layanan . ' oleh : ' . $tagihan->pemohon->name . ', Pelunasan digagalkan';
                    $notifikasi->jenis = 'danger';
                    $notifikasi->url = '/pelayanan';
                    $notifikasi->save();
                }
            }
        }
        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran deleted successfully']);
    }
}
