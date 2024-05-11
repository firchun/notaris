<?php

use App\Http\Controllers\BerkasAkhirController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Layanan;
use App\Models\Pelayanan;
use App\Models\PembayaranPelayanan;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $title = 'Beranda';
    $layanan = Layanan::all();
    return view('pages/index', ['title' => $title, 'layanan' => $layanan]);
});
Route::get('/tentang_kami', function () {
    $data = [
        'title' => 'Tentang Kami',
        'setting' => Setting::latest()->first(),
    ];
    return view('pages/tentang_kami', $data);
});
Route::get('/pengajuan_layanan', function () {
    $title = 'Pengajuan Layanan';
    return view('pages/pengajuan_layanan', ['title' => $title]);
});
Route::get('/kontak_kami', function () {
    $data = [
        'title' => 'Kontak Kami',
        'setting' => Setting::latest()->first(),
    ];
    return view('pages/kontak_kami', $data);
});
Route::get('/tracking', function () {
    $title = 'Tracking Pengajuan';
    return view('pages/tracking', ['title' => $title]);
});
Route::get('/dokumen/{no_dokumen}', [HomeController::class, 'tracking'])->name('dokumen');
Route::get('/setujui-dokumen/{id}', [PelayananController::class, 'setujuiDokumen'])->name('setujui-dokumen');
Route::get('berkas/get-api-berkas/{id}',  [BerkasAkhirController::class, 'getBerkasAkhir'])->name('berkas.api-berkas');
Auth::routes(['verify' => true]);
Route::middleware(['auth:web', 'verified'])->group(function () {

    //dashboard
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth:web', 'verified', 'role:User'])->group(function () {
    Route::get('/pengajuan_user', function () {
        $data = [
            'title' => 'Pengajuan Anda',
            'pelayanan' => Pelayanan::where('id_user', Auth::user()->id)->get(),
        ];
        return view('pages/pengajuan_user', $data);
    });
    Route::get('/pengajuan_layanan/{id}', function ($id) {
        $layanan = Layanan::find($id);
        $data = [
            'title' => 'Ajukan Layanan : ' . $layanan->nama_layanan,
            'layanan' => $layanan,
        ];
        return view('pages/pengajuan', $data);
    })->name('pengajuan_layanan');
    //profile
    Route::get('/profile_user', [ProfileController::class, 'profileUser'])->name('profile_user');
    //pengajuan layanan
    Route::post('/pengajuan_layanan/store',  [PelayananController::class, 'store'])->name('pengajuan_layanan.store');
});
Route::middleware(['auth:web', 'verified', 'role:Admin,Staff,Keuangan'])->group(function () {
    Route::get('/layanans-datatable', [LayananController::class, 'getLayanansDataTable']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //laporan
    Route::get('/report/pelayanan', [LaporanController::class, 'pelayanan'])->name('report.pelayanan');
    Route::get('/report/pembayaran', [LaporanController::class, 'pembayaran'])->name('report.pembayaran');
    Route::get('/report/layanan', [LaporanController::class, 'layanan'])->name('report.layanan');
    //pelayanan
    Route::get('/pelayanan/show/{id}',  [PelayananController::class, 'show'])->name('pelayanan.show');
    Route::get('/pelayanan', [PelayananController::class, 'index'])->name('pelayanan');
    Route::get('/pelayanans-datatable', [PelayananController::class, 'getPelayanansDataTable']);
    Route::get('/all-pembayaran-datatable', [PembayaranController::class, 'getAllPembayaranDataTable']);
    Route::get('/send-wa/{id}', [PelayananController::class, 'sendWa'])->name('send-wa');
});
Route::middleware(['auth:web', 'verified', 'role:Staff'])->group(function () {
    //upload berkas akhir
    Route::post('berkas/upload-berkas',  [BerkasAkhirController::class, 'uploadBerkas'])->name('berkas.upload-berkas');
    Route::post('berkas/terima-berkas',  [BerkasAkhirController::class, 'terimaBerkas'])->name('berkas.terima-berkas');
    //pelayanan managemen
    Route::post('/pelayanan/store',  [PelayananController::class, 'store'])->name('pelayanan.store');
    Route::get('/pelayanan/terima/{id}',  [PelayananController::class, 'terima'])->name('pelayanan.terima');
    Route::get('/pelayanan/tolak/{id}',  [PelayananController::class, 'tolak'])->name('pelayanan.tolak');
    Route::post('/pelayanan/input-biaya',  [PelayananController::class, 'inputBiaya'])->name('pelayanan.input-biaya');
    Route::delete('/pelayanan/delete/{id}',  [PelayananController::class, 'destroy'])->name('pelayanan.delete');
});
Route::middleware(['auth:web', 'verified', 'role:Keuangan'])->group(function () {
    //biaya managemen
    Route::get('/biaya', [PelayananController::class, 'biaya'])->name('biaya');
    //pembayaran
    Route::get('/pembayaran-datatable/{id}', [PembayaranController::class, 'getPembayaranDataTable']);
    Route::post('/pembayaran/store',  [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::post('/pembayaran/delete/{id}',  [PembayaranController::class, 'destroy'])->name('pembayaran.delete');
});
Route::middleware(['auth:web', 'verified', 'role:Admin'])->group(function () {
    //settings managemen
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
    Route::post('/settings/store', [HomeController::class, 'storeSettings'])->name('settings.store');
    //layanans managemen
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::post('/layanan/store',  [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/edit/{id}',  [LayananController::class, 'edit'])->name('layanan.edit');
    Route::get('/layanan/berkas/{id}',  [LayananController::class, 'berkas'])->name('layanan.berkas');
    Route::get('/layanan/formulir/{id}',  [LayananController::class, 'formulir'])->name('layanan.formulir');
    Route::delete('/layanan/delete/{id}',  [LayananController::class, 'destroy'])->name('layanan.delete');
    // Route::get('/layanans-datatable', [LayananController::class, 'getLayanansDataTable']);

    //berkas layanan managemen
    Route::post('/berkas/store',  [LayananController::class, 'storeBerkas'])->name('berkas.store');
    Route::get('/berkas/edit/{id}',  [LayananController::class, 'editBerkas'])->name('berkas.edit');
    Route::delete('/berkas/delete/{id}',  [LayananController::class, 'destroyBerkas'])->name('berkas.delete');
    Route::get('/berkas-datatable/{id}', [LayananController::class, 'getberkasDataTable']);
    //formulir layanan managemen
    Route::post('/formulir/store',  [LayananController::class, 'storeFormulir'])->name('formulir.store');
    Route::get('/formulir/edit/{id}',  [LayananController::class, 'editFormulir'])->name('formulir.edit');
    Route::delete('/formulir/delete/{id}',  [LayananController::class, 'destroyFormulir'])->name('formulir.delete');
    Route::get('/formulir-datatable/{id}', [LayananController::class, 'getFormulirDataTable']);
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/customers', [UserController::class, 'customers'])->name('customers');
    Route::get('/admins', [UserController::class, 'admins'])->name('admins');
    Route::get('/staffs', [UserController::class, 'staffs'])->name('staffs');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable', [UserController::class, 'getUsersDataTable']);
    Route::get('/customers-datatable', [UserController::class, 'getCustomersDataTable']);
    Route::get('/staffs-datatable', [UserController::class, 'getStaffsDataTable']);
    Route::get('/admins-datatable', [UserController::class, 'getAdminsDataTable']);
});
