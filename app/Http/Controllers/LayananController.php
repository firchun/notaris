<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
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
    public function getLayanansDataTable()
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
            ->rawColumns(['action', 'gambar', 'jenis'])
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
    public function destroy($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return response()->json(['message' => 'layanan not found'], 404);
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
}
