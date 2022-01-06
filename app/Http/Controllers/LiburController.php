<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libur;

class LiburController extends Controller
{
    public function index()
    {
        return view('pages.transaksi.libur-data', [
            'libur' => Libur::class
        ]);
    }
    public function indexapi()
    {
        $liburs = Libur::with('pegawai')->orderBy('tanggal', 'desc')->get();
        return response()->json([
            'status' => 200,
            'liburs' => $liburs,
        ]);
    }
    public function showapi($id)
    {
        $libur = Libur::find($id);
        return response()->json([
            'status' => 200,
            'libur' => $libur,
        ]);
    }
    public function updateapi(Request $request, $id)
    {
        Libur::find($id)->update($request->only([
            'tanggal',
            'pegawai_id',
            'keterangan',
            'jumlah',
        ]));
        return response()->json([
            'messages' => 'Berhasil Update',
            'status' => 200
        ]);
    }
    public function storeapi(Request $request)
    {
        Libur::create($request->only([
            'tanggal',
            'pegawai_id',
            'keterangan',
            'jumlah',
        ]));
        return response()->json([
            'messages' => 'Berhasil Menyimpan Data Libur',
            'status' => 200
        ]);
    }
    public function destroyapi($id)
    {
        $libur = Libur::find($id);
        $libur->delete();
        return response()->json([
            'status' => 200,
            'messages' => 'Berhasil Menghapus Data Libur',
        ]);
    }
}
