<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Layanan;
use App\Models\Pelayanan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'User') {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Dashboard',
            'users' => User::where('role', 'User')->count(),
            'staff' => User::where('role', 'Staff')->count(),
            'keuangan' => User::where('role', 'Keuangan')->count(),
            'layanan' => Layanan::count(),
            'total_pengajuan' => Pelayanan::count(),
            'total_pengajuan_new' => Pelayanan::where('is_verified', 0)->count(),
            'total_pengajuan_verified' => Pelayanan::where('is_verified', 1)->count(),
            'total_pengajuan_not_confirm' => Pelayanan::where('is_verified', 1)->where('is_continue', 0)->count(),
            'total_pengajuan_confirm' => Pelayanan::where('is_verified', 1)->where('is_continue', 1)->count(),
            'total_pengajuan_not_lunas' => Pelayanan::where('is_verified', 1)->where('is_continue', 1)->where('is_paid', 0)->count(),
            'total_pengajuan_lunas' => Pelayanan::where('is_verified', 1)->where('is_continue', 1)->where('is_paid', 1)->count(),
            'total_pengajuan_send' => Pelayanan::where('is_verified', 1)->where('is_continue', 1)->where('is_send', 1)->count(),
        ];
        return view('admin.dashboard', $data);
    }
    public function settings()
    {
        $data = [
            'title' => 'Pengaturan',
            'setting' => Setting::latest()->first(),
        ];
        return view('admin.settings.index', $data);
    }
    public function storeSettings(Request $request)
    {
        // Validasi data
        $request->validate([
            'tentang_kami' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|email',
            'alamat' => 'required|string',
        ]);

        try {
            // Ambil ID setting jika sudah ada
            $id = $request->input('id');

            // Buat atau perbarui data setting
            $setting = $id ? Setting::findOrFail($id) : new Setting();

            // Set nilai atribut setting dari input form
            $setting->tentang_kami = $request->input('tentang_kami');
            $setting->no_hp = $request->input('no_hp');
            $setting->email = $request->input('email');
            $setting->alamat = $request->input('alamat');

            // Simpan data setting
            $setting->save();

            // Redirect dengan pesan sukses
            session()->flash('success', 'Data setting berhasil disimpan.');
            return redirect()->route('settings.index')->with('success', 'Data setting berhasil disimpan.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Data setting gagal disimpan.');
        }
    }
    public function tracking($no_dokumen)
    {
        $pelayanan = Pelayanan::where('no_dokumen', $no_dokumen)->with(['status', 'staff', 'pemohon', 'layanan', 'formulir', 'berkas'])->first();

        $berkasPelayanan = $pelayanan->berkas;
        $berkasLayananData = [];

        foreach ($berkasPelayanan as $bp) {
            $berkasLayanan = $bp->berkas_layanan;

            foreach ($berkasLayanan as $bl) {
                $berkasLayananData[] = $bl;
            }
        }
        $formulirPelayanan = $pelayanan->formulir;
        $formulirLayananData = [];

        foreach ($formulirPelayanan as $bp) {
            $formulirLayanan = $bp->formulir_layanan;

            foreach ($formulirLayanan as $bl) {
                $formulirLayananData[] = $bl;
            }
        }

        $pelayanan['formulir_layanan'] = $formulirLayananData;
        $pelayanan['berkas_layanan'] = $berkasLayananData;
        return response()->json($pelayanan);
    }
}
