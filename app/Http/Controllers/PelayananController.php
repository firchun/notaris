<?php

namespace App\Http\Controllers;

use App\Models\BerkasLayanan;
use App\Models\BerkasPelayanan;
use App\Models\FormulirPelayanan;
use App\Models\Layanan;
use App\Models\Pelayanan;
use App\Models\PelayananStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PelayananController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengajuan layanan',
        ];
        return view('admin.pelayanan.index', $data);
    }
    public function biaya()
    {
        $data = [
            'title' => 'Biaya Dokumen',
        ];
        return view('admin.biaya.index', $data);
    }
    public function getPelayanansDataTable()
    {
        $pelayanan = Pelayanan::with(['layanan', 'pemohon', 'staff'])->orderByDesc('id');

        return Datatables::of($pelayanan)
            ->addColumn('action', function ($pelayanan) {
                return view('admin.pelayanan.components.actions', compact('pelayanan'));
            })
            ->addColumn('action_biaya', function ($pelayanan) {
                return view('admin.biaya.components.actions', compact('pelayanan'));
            })
            ->addColumn('date', function ($pelayanan) {
                return $pelayanan->created_at->format('d F Y');
            })
            ->addColumn('biaya', function ($pelayanan) {
                $warna = $pelayanan->is_paid == 0 ? 'text-danger' : 'text-success';
                $text = $pelayanan->is_paid == 0 ? 'Belum Lunas' : 'LUNAS';
                return number_format($pelayanan->biaya) . '<br> <span class="' . $warna . '">' . $text . '</span>';
            })
            ->addColumn('pemohon', function ($pelayanan) {
                return '<strong>' . $pelayanan->nama_pemohon . '</strong><br><small class="text-muted">' . $pelayanan->pemohon->email . '</small>';
            })
            ->addColumn('status', function ($pelayanan) {
                return PelayananStatus::where('id_pelayanan', $pelayanan->id)->latest()->first()->status;
            })
            ->rawColumns(['action', 'action_biaya', 'status', 'pemohon', 'date', 'biaya'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'id_layanan' => 'required',
            'id_user' => 'required',
            'berkas.*' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $layanan = Layanan::find($request->id_layanan);
        $jenis = $layanan->jenis == 'Notaris' ? 'NOT' : 'PAT';

        $permohonanData = [
            'nama_pemohon' => $request->input('nama_pemohon'),
            'id_layanan' => $request->input('id_layanan'),
            'id_user' => $request->input('id_user'),
        ];

        $random_number = mt_rand(10000, 99999);
        $permohonanData['no_dokumen'] = 'AM' . $random_number . $jenis;
        $pelayanan = Pelayanan::create($permohonanData);


        foreach ($request->file('berkas') as $key => $file) {
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $file_path_berkas = $file->storeAs('public/berkas', $filename);

            $berkas_layanan = new BerkasPelayanan();
            $berkas_layanan->id_berkas_layanan = $request->input('id_berkas_layanan')[$key]; // Pastikan nilai ini adalah nilai tunggal, bukan array
            $berkas_layanan->berkas = $file_path_berkas;
            $berkas_layanan->id_pelayanan = $pelayanan->id;
            $berkas_layanan->save();
        }

        foreach ($request->input('id_formulir_layanan') as $key => $id_formulir_layanan) {
            $formulir_pelayanan = new FormulirPelayanan();
            $formulir_pelayanan->id_formulir_layanan = $id_formulir_layanan;
            $formulir_pelayanan->id_pelayanan = $pelayanan->id;
            $formulir_pelayanan->isi_formulir = $request->input('isi_formulir')[$key];
            $formulir_pelayanan->save();
        }
        $status = new PelayananStatus();
        $status->id_pelayanan = $pelayanan->id;
        $status->status = 'Menunggu verifikasi oleh staf';
        $status->save();

        $message = 'Pengajuan telah berhasil';
        return redirect()->to('/pengajuan_user')->withSuccess($message);
    }
    public function show($id)
    {
        $layanan = Pelayanan::with(['pemohon', 'layanan', 'staff', 'berkas', 'formulir', 'status'])->find($id);

        if (!$layanan) {
            return response()->json(['message' => 'Pengajuan not found'], 404);
        }
        $berkasPelayanan = $layanan->berkas;
        $berkasLayananData = [];

        foreach ($berkasPelayanan as $bp) {
            $berkasLayanan = $bp->berkas_layanan;

            foreach ($berkasLayanan as $bl) {
                $berkasLayananData[] = $bl;
            }
        }
        $formulirPelayanan = $layanan->formulir;
        $formulirLayananData = [];

        foreach ($formulirPelayanan as $bp) {
            $formulirLayanan = $bp->formulir_layanan;

            foreach ($formulirLayanan as $bl) {
                $formulirLayananData[] = $bl;
            }
        }

        $layanan['formulir_layanan'] = $formulirLayananData;
        $layanan['berkas_layanan'] = $berkasLayananData;
        return response()->json($layanan);
    }
    public function terima($id)
    {
        $pelayanan = Pelayanan::find($id);
        $pelayanan->is_verified = 1;
        $pelayanan->id_staff = Auth::id();
        $pelayanan->update();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::id();
        $status->status = 'Berkas Berhasil diverifikasi';
        $status->save();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::id();
        $status->status = 'Proses perhitungan biaya';
        $status->save();

        return response()->json(['message' => 'Data berhasil diverifikasi']);
    }
    public function tolak($id)
    {
        $pelayanan = Pelayanan::find($id);
        $pelayanan->is_verified = 2;
        $pelayanan->id_staff = Auth::user()->id;
        $pelayanan->update();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::user()->id;
        $status->status = 'Berkas ditolak';
        $status->save();

        return response()->json(['message' => 'Data berhasil ditolak']);
    }
    public function inputBiaya(Request $request)
    {
        $biaya = $request->input('biaya');
        $id = $request->input('id');

        $pelayanan = Pelayanan::find($id);
        $pelayanan->biaya = $biaya;
        $pelayanan->update();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::user()->id;
        $status->status = 'Menunggu persetujuan kelanjutan dokumen';
        $status->save();

        return response()->json(['message' => 'Biaya berhasil diinput']);
    }
    public function setujuiDokumen($id)
    {

        $pelayanan = Pelayanan::find($id);
        $pelayanan->is_continue = 1;
        $pelayanan->update();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::user()->id;
        $status->status = 'Proses pengurusan dokumen';
        $status->save();
        session()->flash('success', 'Berhasil menyetujui layanan');
        return redirect()->back();
    }
}
