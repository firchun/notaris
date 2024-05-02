<?php

namespace App\Http\Controllers;

use App\Models\Pelayanan;
use App\Models\PelayananStatus;
use App\Models\PembayaranPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function getPembayaranDataTable($id)
    {
        $pembayaran = PembayaranPelayanan::with(['pelayanan', 'staff'])->where('id_pelayanan', $id)->orderByDesc('id');

        return Datatables::of($pembayaran)
            ->addColumn('total', function ($pembayaran) {
                return 'Rp ' . number_format($pembayaran->total);
            })
            ->addColumn('action', function ($pembayaran) {
                return '<button class="btn btn-sm btn-danger" onclick="destroyPembayaran(' . $pembayaran->id . ')"><i class="bx bx-trash"></i></button>';
            })
            ->rawColumns(['total', 'action'])
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
            session()->flash('success', 'Pembayaran telah lunas');
        }
        $pembayaran = new PembayaranPelayanan();
        $pembayaran->id_staff = Auth::id();
        $pembayaran->id_pelayanan = $request->input('id');
        $pembayaran->total = $request->input('total');
        $pembayaran->save();
        return response()->json(['message' => 'Berhasil menambah pembayaran']);
    }
    public function destroy($id)
    {
        $pembayaran = PembayaranPelayanan::find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Pemabayaran not found'], 404);
        }

        $pembayaran->delete();

        return response()->json(['message' => 'Pemabayaran deleted successfully']);
    }
}
