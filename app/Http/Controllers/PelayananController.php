<?php

namespace App\Http\Controllers;

use App\Models\BerkasAkhir;
use App\Models\BerkasLayanan;
use App\Models\BerkasPelayanan;
use App\Models\FormulirPelayanan;
use App\Models\Layanan;
use App\Models\Notifikasi;
use App\Models\Pelayanan;
use App\Models\PelayananStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public function getPelayanansDataTable(Request $request)
    {
        $pelayanan = Pelayanan::with(['layanan', 'pemohon', 'staff'])->orderByDesc('id');
        if ($request->tanggal_awal != null || $request->tanggal_awal != '') {
            $pelayanan->where('created_at', '>=', $request->tanggal_awal)->where('created_at', '<=', $request->tanggal_akhir);
        }
        if ($request->pembayaran != null || $request->pembayaran != '') {
            if ($request->pembayaran == 'lunas') {
                $pelayanan->where('is_paid', 1);
            } else {
                $pelayanan->where('is_paid', 0);
            }
        }
        if ($request->layanan != null || $request->layanan != '') {
            $pelayanan->where('id_layanan', $request->layanan);
        }

        return Datatables::of($pelayanan)
            ->addColumn('action', function ($pelayanan) {
                $cek_berkas = BerkasAkhir::where('id_pelayanan', $pelayanan->id);
                return view('admin.pelayanan.components.actions', compact('pelayanan', 'cek_berkas'));
            })
            ->addColumn('capture', function ($pelayanan) {
                return '<a href="' . Storage::url($pelayanan->capture) . '" target="__blank"><img src="' . Storage::url($pelayanan->capture) . '" alt="capture" style="width:100px;"></a>';
            })
            ->addColumn('action_biaya', function ($pelayanan) {
                return view('admin.biaya.components.actions', compact('pelayanan'));
            })
            ->addColumn('date', function ($pelayanan) {
                return $pelayanan->created_at->format('d F Y');
            })
            ->addColumn('biaya_text', function ($pelayanan) {
                $warna = $pelayanan->is_paid == 0 ? 'text-danger' : 'text-success';
                $text = $pelayanan->is_paid == 0 ? 'Belum Lunas' : 'LUNAS';
                return number_format($pelayanan->biaya) . '<br> <span class="' . $warna . '">' . $text . '</span>';
            })
            ->addColumn('pemohon', function ($pelayanan) {
                return '<strong>' . $pelayanan->nama_pemohon . '</strong><br><small class="text-muted">' . $pelayanan->pemohon->email . '</small>';
            })
            ->addColumn('status', function ($pelayanan) {
                return PelayananStatus::where('id_pelayanan', $pelayanan->id)->latest()->first()->status ?? '';
            })
            ->addColumn('pembayaran', function ($pelayanan) {
                $warna = $pelayanan->is_paid == 0 ? 'text-danger' : 'text-success';
                $text = $pelayanan->is_paid == 0 ? 'Belum Lunas' : 'LUNAS';
                return  '<span class="' . $warna . '">' . $text . '</span>';
            })
            ->addColumn('send', function ($pelayanan) {
                $warna = $pelayanan->is_send == 0 ? 'outline-success' : 'outline-muted';
                return  '<button type="button"  onclick="sendWhatsapp(' . $pelayanan->id . ')" class=" btn btn-sm btn-' . $warna . '"><i class="bx bxl-whatsapp bx-sm"></i></button>';
            })
            ->rawColumns(['action', 'action_biaya', 'status', 'pemohon', 'date', 'biaya_text', 'pembayaran', 'send', 'capture'])
            ->make(true);
    }
    public function storePerbaikan(Request $request)
    {
        $request->validate([
            'berkas.*' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'berkas.*.max' => 'Ukuran file tidak boleh melebihi 10MB.',
            'berkas.*.mimes' => 'Berkas :attribute harus berformat PDF.',
        ]);


        $permohonanData = [
            'is_verified' => 0,
        ];

        $pelayanan = Pelayanan::find($request->id);
        $pelayanan->update($permohonanData);
        $layanan = Layanan::find($pelayanan->id_layanan);

        if ($request->file('berkas')) {
            foreach ($request->file('berkas') as $key => $file) {
                // Cek apakah ada berkas yang sudah ada
                $berkas_layanan = BerkasPelayanan::where('id_berkas_layanan', $request->input('id_berkas_layanan')[$key])
                    ->where('id_pelayanan', $pelayanan->id)
                    ->first();

                if ($berkas_layanan) {
                    // Jika berkas sudah ada, hapus yang lama
                    Storage::delete($berkas_layanan->berkas);
                }

                // Generate nama file yang unik
                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();

                // Simpan berkas ke storage
                $file_path_berkas = $file->storeAs('public/berkas', $filename);

                if ($berkas_layanan) {
                    // Update data berkas yang sudah ada
                    $berkas_layanan->update([
                        'berkas' => $file_path_berkas,
                    ]);
                } else {
                    // Jika berkas belum ada, simpan data baru
                    $berkas_layanan = new BerkasPelayanan();
                    $berkas_layanan->id_berkas_layanan = $request->input('id_berkas_layanan')[$key]; // Pastikan ini nilai tunggal, bukan array
                    $berkas_layanan->berkas = $file_path_berkas;
                    $berkas_layanan->id_pelayanan = $pelayanan->id;
                    $berkas_layanan->save();
                }
            }
        }

        foreach ($request->input('id_formulir_layanan') as $key => $id_formulir_layanan) {
            $formulir_pelayanan = FormulirPelayanan::where('id_formulir_layanan', $id_formulir_layanan)
                ->where('id_pelayanan', $pelayanan->id)
                ->first();

            if ($formulir_pelayanan) {
                // Jika formulir sudah ada, update
                $formulir_pelayanan->update([
                    'isi_formulir' => $request->input('isi_formulir')[$key],
                ]);
            } else {
                // Jika formulir belum ada, simpan data baru
                $formulir_pelayanan = new FormulirPelayanan();
                $formulir_pelayanan->id_formulir_layanan = $id_formulir_layanan;
                $formulir_pelayanan->id_pelayanan = $pelayanan->id;
                $formulir_pelayanan->isi_formulir = $request->input('isi_formulir')[$key];
                $formulir_pelayanan->save();
            }
        }
        //status pelayanan
        $status = new PelayananStatus();
        $status->id_pelayanan = $pelayanan->id;
        $status->status = 'Menunggu verifikasi ulang oleh staf';
        $status->save();

        //notifikasi 
        $staff = User::where('role', 'Staff')->get();
        $pemohon = User::find(Auth::user()->id);
        foreach ($staff as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Sdr.' . $pemohon->name . ', telah mengajukan perbaikan pada permohonan layanan : ' . $layanan->nama_layanan;
            $notifikasi->jenis = 'primary';
            $notifikasi->url = '/pelayanan';
            $notifikasi->save();
        }


        $message = 'Perbaikan Pengajuan telah berhasil';
        return redirect()->to('/pengajuan_user')->withSuccess($message);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'id_layanan' => 'required',
            'id_user' => 'required',
            'capture' => 'required',
            'berkas.*' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'berkas.*.max' => 'Ukuran file tidak boleh melebihi 10MB.',
            'berkas.*.mimes' => 'Berkas :attribute harus berformat PDF.',
        ]);

        $layanan = Layanan::find($request->id_layanan);
        $jenis = $layanan->jenis == 'Notaris' ? 'NOT' : 'PAT';

        $permohonanData = [
            'nama_pemohon' => $request->input('nama_pemohon'),
            'id_layanan' => $request->input('id_layanan'),
            'id_user' => $request->input('id_user'),
            'capture' => $request->input('capture'),
        ];
        $capture = $request->file('capture');
        $filename_capture = Str::random(32) . '.' . $capture->getClientOriginalExtension();
        $file_path_capture = $capture->storeAs('public/berkas', $filename_capture);

        $random_number = mt_rand(10000, 99999);
        $permohonanData['capture'] = $file_path_capture;
        $permohonanData['no_dokumen'] = 'AM' . $random_number . $jenis;
        $pelayanan = Pelayanan::create($permohonanData);

        if ($request->file('berkas')) {

            foreach ($request->file('berkas') as $key => $file) {
                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                $file_path_berkas = $file->storeAs('public/berkas', $filename);

                $berkas_layanan = new BerkasPelayanan();
                $berkas_layanan->id_berkas_layanan = $request->input('id_berkas_layanan')[$key]; // Pastikan nilai ini adalah nilai tunggal, bukan array
                $berkas_layanan->berkas = $file_path_berkas;
                $berkas_layanan->id_pelayanan = $pelayanan->id;
                $berkas_layanan->save();
            }
        }

        foreach ($request->input('id_formulir_layanan') as $key => $id_formulir_layanan) {
            $formulir_pelayanan = new FormulirPelayanan();
            $formulir_pelayanan->id_formulir_layanan = $id_formulir_layanan;
            $formulir_pelayanan->id_pelayanan = $pelayanan->id;
            $formulir_pelayanan->isi_formulir = $request->input('isi_formulir')[$key];
            $formulir_pelayanan->save();
        }
        //status pelayanan
        $status = new PelayananStatus();
        $status->id_pelayanan = $pelayanan->id;
        $status->status = 'Menunggu verifikasi oleh staf';
        $status->save();

        //notifikasi 
        $staff = User::where('role', 'Staff')->get();
        $pemohon = User::find(Auth::user()->id);
        foreach ($staff as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Sdr.' . $pemohon->name . ', telah mengajukan permohonan layanan : ' . $layanan->nama_layanan;
            $notifikasi->jenis = 'primary';
            $notifikasi->url = '/pelayanan';
            $notifikasi->save();
        }


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

        //notifikasi
        $keuangan = User::where('role', 'Keuangan')->get();
        $staff = User::find(Auth::id());
        foreach ($keuangan as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Staff An.' . $staff->name . ', telah Menyetujui permohonan, menunggu perhitungan biaya';
            $notifikasi->jenis = 'warning';
            $notifikasi->url = '/biaya';
            $notifikasi->save();
        }

        return response()->json(['message' => 'Data berhasil diverifikasi']);
    }
    public function tolak(Request $request, $id)
    {
        if ($request->input('keterangan') == null || $request->input('keterangan') == '') {
            return response()->json(['message' => 'Keterangan penolakan harus diisi!']);
        }
        $pelayanan = Pelayanan::find($id);
        $pelayanan->is_verified = 2;
        $pelayanan->id_staff = Auth::user()->id;
        $pelayanan->keterangan = $request->input('keterangan');
        $pelayanan->save();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::user()->id;
        $status->status = 'Berkas ditolak';
        $status->save();

        return response()->json(['message' => 'Data berhasil ditolak']);
    }
    public function perbaiki($id)
    {
        $pelayanan = Pelayanan::find($id);
        $pelayanan->is_verified = 0;
        $pelayanan->id_staff = Auth::user()->id;
        $pelayanan->update();

        $status = new PelayananStatus();
        $status->id_pelayanan = $id;
        $pelayanan->id_staff = Auth::user()->id;
        $status->status = 'Berkas dikembalikan';
        $status->save();

        return response()->json(['message' => 'Data berhasil di kembalikan']);
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

        //notifikasi 
        $staff = User::where('role', 'Staff')->get();
        $keuangan = User::where('role', 'Keuangan')->get();
        $pemohon = User::find(Auth::user()->id);
        foreach ($staff as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Sdr.' . $pemohon->name . ', telah menyetujui biaya layanan dan melanjutkan pemrosesan berkas';
            $notifikasi->jenis = 'primary';
            $notifikasi->url = '/pelayanan';
            $notifikasi->save();
        }
        foreach ($keuangan as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_user = $item->id;
            $notifikasi->isi_notifikasi = 'Sdr.' . $pemohon->name . ', telah menyetujui biaya layanan dan melanjutkan pemrosesan berkas';
            $notifikasi->jenis = 'primary';
            $notifikasi->url = '/biaya';
            $notifikasi->save();
        }

        session()->flash('success', 'Berhasil menyetujui layanan');
        return redirect()->back();
    }
    public function sendWa($id)
    {
        $pelayanan =  Pelayanan::where('id', $id)->with('pemohon')->first();
        if (Auth::user()->role != 'Keuangan') {
            $cek_berkas_akhir = BerkasAkhir::where('id_pelayanan', $pelayanan->id)->first();
            if ($pelayanan->is_verified == 1 && $pelayanan->biaya == 0) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Telah di verifikasi dan menunggu perhitungan biaya \n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                    url('/pengajuan_user') . "\n";
            } elseif ($pelayanan->is_verified == 0) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Menunggu verifikasi oleh staff \n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                    url('/pengajuan_user') . "\n";
            } elseif ($pelayanan->is_verified == 2) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Berkas di tolak dan harap untuk di lengkapi kembali, \n" .
                    "Keterangan : " . $pelayanan->keterangan . " \n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                    url('/pengajuan_user') . "\n";
            } elseif ($cek_berkas_akhir->count() != 0) {
                if ($cek_berkas_akhir->diterima == 0) {

                    $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                        "Berkas telah selesai, silahkan mengambil di kantor \n" .
                        "-------------------------------------\n" .
                        "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                        url('/pengajuan_user') . "\n";
                } else {
                    $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                        "Berkas telah diterima \n" .
                        "-------------------------------------\n" .
                        "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                        url('/pengajuan_user') . "\n";
                }
            } else {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Telah di verifikasi dan menunggu perhitungan biaya \n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progreess dokumen \n" .
                    url('/pengajuan_user') . "\n";
            }
            $pesan_encoded = urlencode($pesan);
            $url = 'https://api.whatsapp.com/send?phone=' . $pelayanan->pemohon->no_hp . '&text=' . $pesan_encoded;
        } elseif (Auth::user()->role == 'Keuangan') {
            $cek_berkas_akhir = BerkasAkhir::where('id_pelayanan', $pelayanan->id)->count();
            $cek_berkas_akhir_diterima = BerkasAkhir::where('id_pelayanan', $pelayanan->id)->latest()->first()->diterima;
            //api wa
            if ($pelayanan->is_continue == 0) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Total Tagihan : Rp. " . $pelayanan->biaya . "\n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda dan konfirmasi untuk melanjutkan dokumen \n" .
                    url('/pengajuan_user') . "\n" .
                    "-------------------------------------\n" .
                    "Pembayaran dapat di bayarkan langsung ke kantor atau bisa dengan transfer pada bank yang tersedia sebagai berikut : \n" .
                    "1. Bank Negara Indonesia (Persero) Tbk,Cabang Merauke di Nomor Rekening Giro : 8888811793 a/n Ahmad Ali Muddin\n" .
                    "2. Bank Mandiri (Persero) Tbk, di Nomor Rekening : 1520001417746 a/n Ahmad Ali Muddin\n";
            } elseif ($pelayanan->is_continue == 1) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Total Tagihan : Rp. " . $pelayanan->biaya . "\n" .
                    "Status : Telah dilanjutkan dan dokumen akan di proses\n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progress dokumen \n" .
                    url('/pengajuan_user') . "\n" .
                    "-------------------------------------\n" .
                    "Pembayaran dapat di bayarkan langsung ke kantor atau bisa dengan transfer pada bank yang tersedia sebagai berikut : \n" .
                    "1. Bank Negara Indonesia (Persero) Tbk,Cabang Merauke di Nomor Rekening Giro : 8888811793 a/n Ahmad Ali Muddin\n" .
                    "2. Bank Mandiri (Persero) Tbk, di Nomor Rekening : 1520001417746 a/n Ahmad Ali Muddin\n";
            } elseif ($pelayanan->is_paid == 1) {
                $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                    "Total Tagihan : Rp. " . $pelayanan->biaya . "\n" .
                    "Status : Berkas telah lunas dan dokumen di proses\n" .
                    "-------------------------------------\n" .
                    "Silahkan login pada akun anda untuk melihat progress dokumen \n" .
                    url('/pengajuan_user') . "\n";
            } elseif ($pelayanan->is_paid == 1 &&  $cek_berkas_akhir != 0) {
                if ($cek_berkas_akhir_diterima == 1) {
                    $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                        "Total Tagihan : Rp. " . $pelayanan->biaya . "\n" .
                        "Status : Berkas telah selesai dan telah diterima\n" .
                        "-------------------------------------\n" .
                        "Silahkan login pada akun anda untuk melihat progress dokumen \n" .
                        url('/pengajuan_user') . "\n";
                } else {
                    $pesan = "No. Dokumen: " . $pelayanan->no_dokumen . "\n" .
                        "Total Tagihan : Rp. " . $pelayanan->biaya . "\n" .
                        "Status : Berkas telah selesai di proses dan siap diambil\n" .
                        "-------------------------------------\n" .
                        "Silahkan login pada akun anda untuk melihat progress dokumen \n" .
                        url('/pengajuan_user') . "\n";
                }
            }

            $pesan_encoded = urlencode($pesan);
            $url = 'https://api.whatsapp.com/send?phone=' . $pelayanan->pemohon->no_hp . '&text=' . $pesan_encoded;
        } else {
            return back();
        }

        if ($pelayanan->is_send == 0) {
            $pelayanan->is_send = 1;
            $pelayanan->save();
            return response()->json(['url' => $url, 'status' => 'Anda akan dialihkan untuk mengirim tagihan via whatsapp..']);
        } elseif ($pelayanan->is_send == 1) {
            return response()->json(['url' => $url, 'status' => 'Tagihan telah dikirim sebelumnya, apakah ingin mengirim ulang?.']);
        } else {
            return response()->json(['status' => 'Gagal']);
        }
    }
}
