<?php

namespace App\Http\Controllers;

use App\Models\BerkasLayanan;
use App\Models\FormulirLayanan;
use App\Models\Layanan;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LayananController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data layanan',
        ];
        return view('admin.layanan.index', $data);
    }
    public function formulir($id)
    {
        $layanan = Layanan::find($id);
        $data = [
            'title' => 'Formulir Layanan : ' . $layanan->nama_layanan,
            'layanan' => $layanan,
        ];
        return view('admin.layanan.formulir', $data);
    }
    public function berkas($id)
    {
        $layanan = Layanan::find($id);
        $data = [
            'title' => 'Berkas Layanan : ' . $layanan->nama_layanan,
            'layanan' => $layanan,
        ];
        return view('admin.layanan.berkas', $data);
    }
    public function getLayanansDataTable(Request $request)
    {
        $layanan = Layanan::orderByDesc('id');

        return Datatables::of($layanan)
            ->addColumn('action', function ($layanan) {
                return view('admin.layanan.components.actions', compact('layanan'));
            })
            ->addColumn('gambar', function ($layanan) {
                return '<img src="' . asset('img/layanan.png') . '" style="width:100px;"/>';
            })
            ->addColumn('jenis', function ($layanan) {
                return $layanan->jenis_layanan == 'PPAT' ? '<span class="badge bg-label-primary">PPAT</span>' : '<span class="badge bg-label-success">Notaris</span>';
            })
            ->addColumn('jumlah', function ($layanan) {
                return Pelayanan::where('id_layanan', $layanan->id)->count() . ' Pengajuan';
            })
            ->addColumn('berkas', function ($layanan) {
                $berkas = BerkasLayanan::where('id_layanan', $layanan->id)->pluck('nama_berkas')->toArray();
                $listBerkas = '<ul>';
                foreach ($berkas as $namaBerkas) {
                    $listBerkas .= '<li>' . $namaBerkas . '</li>';
                }
                $listBerkas .= '</ul>';
                return $listBerkas;
            })
            ->addColumn('formulir', function ($layanan) {
                $Formulir = FormulirLayanan::where('id_layanan', $layanan->id)->pluck('nama_formulir')->toArray();
                $listFormulir = '<ul>';
                foreach ($Formulir as $namaFormulir) {
                    $listFormulir .= '<li>' . $namaFormulir . '</li>';
                }
                $listFormulir .= '</ul>';
                return $listFormulir;
            })
            ->rawColumns(['action', 'gambar', 'jenis', 'berkas', 'formulir', 'jumlah'])
            ->make(true);
    }
    public function getberkasDataTable($id)
    {
        $berkas = BerkasLayanan::orderByDesc('id')->where('id_layanan', $id);

        return Datatables::of($berkas)
            ->addColumn('action', function ($berkas) {
                return view('admin.layanan.components.actions_berkas', compact('berkas'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getFormulirDataTable($id)
    {
        $formulir = FormulirLayanan::orderByDesc('id')->where('id_layanan', $id);

        return Datatables::of($formulir)
            ->addColumn('action', function ($formulir) {
                return view('admin.layanan.components.actions_formulir', compact('formulir'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis_layanan' => 'string|max:20',
            'deskripsi' => 'required|string',
            // 'thumbnail' => 'required|string',
        ]);

        $layananData = [
            'nama_layanan' => $request->input('nama_layanan'),
            'jenis_layanan' => $request->input('jenis_layanan'),
            'deskripsi' => $request->input('deskripsi'),
        ];

        if ($request->filled('id')) {
            $layanan = Layanan::find($request->input('id'));
            if (!$layanan) {
                return response()->json(['message' => 'layanan not found'], 404);
            }

            $layanan->update($layananData);
            $message = 'layanan updated successfully';
        } else {
            Layanan::create($layananData);
            $message = 'layanan created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function storeBerkas(Request $request)
    {
        $request->validate([
            'nama_berkas' => 'required|string|max:255',
            'id_layanan' => 'required',
        ]);

        $layananData = [
            'nama_berkas' => $request->input('nama_berkas'),
            'id_layanan' => $request->input('id_layanan'),
        ];

        if ($request->filled('id')) {
            $layanan = BerkasLayanan::find($request->input('id'));
            if (!$layanan) {
                return response()->json(['message' => 'layanan not found'], 404);
            }

            $layanan->update($layananData);
            $message = 'berkas updated successfully';
        } else {
            BerkasLayanan::create($layananData);
            $message = 'berkas created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function storeFormulir(Request $request)
    {
        $request->validate([
            'nama_formulir' => 'required|string|max:255',
            'id_layanan' => 'required',
        ]);

        $layananData = [
            'nama_formulir' => $request->input('nama_formulir'),
            'id_layanan' => $request->input('id_layanan'),
        ];

        if ($request->filled('id')) {
            $layanan = FormulirLayanan::find($request->input('id'));
            if (!$layanan) {
                return response()->json(['message' => 'syarat not found'], 404);
            }

            $layanan->update($layananData);
            $message = 'syarat updated successfully';
        } else {
            FormulirLayanan::create($layananData);
            $message = 'syarat created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'layanan not found'], 404);
        }

        $layanan->delete();

        return response()->json(['message' => 'layanan deleted successfully']);
    }
    public function destroyFormulir($id)
    {
        $layanan = FormulirLayanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'syarat not found'], 404);
        }

        $layanan->delete();

        return response()->json(['message' => 'syarat deleted successfully']);
    }
    public function destroyBerkas($id)
    {
        $layanan = BerkasLayanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'berkas not found'], 404);
        }

        $layanan->delete();

        return response()->json(['message' => 'layanan deleted successfully']);
    }
    public function edit($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'layanan not found'], 404);
        }

        return response()->json($layanan);
    }
    public function editBerkas($id)
    {
        $layanan = BerkasLayanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'berkas not found'], 404);
        }

        return response()->json($layanan);
    }
    public function editFormulir($id)
    {
        $layanan = FormulirLayanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'syarat not found'], 404);
        }

        return response()->json($layanan);
    }
}
