<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use Illuminate\Http\Request;

class BonController extends Controller
{
    public function index()
    {
        return view('pages.transaksi.bon-data', [
            'bon' => Bon::class
        ]);
    }
    public function indexapi()
    {
        $bons = Bon::with('pegawai')->orderBy('tanggal', 'desc')->get();
        return response()->json([
            'status' => 200,
            'bons' => $bons,
        ]);
    }
    public function showapi($id)
    {
        $bon = Bon::find($id);
        return response()->json([
            'status' => 200,
            'bon' => $bon,
        ]);
    }
    public function updateapi(Request $request, $id)
    {
        Bon::find($id)->update($request->only([
            'tanggal',
            'pegawai_id',
            'jumlah',
        ]));
        return response()->json([
            'messages' => 'Berhasil Update',
            'status' => 200
        ]);
    }
    public function storeapi(Request $request)
    {
        Bon::create($request->only([
            'tanggal',
            'pegawai_id',
            'jumlah',
        ]));
        return response()->json([
            'messages' => 'Berhasil Menyimpan Data Bon',
            'status' => 200
        ]);
    }
    public function destroyapi($id)
    {
        $bon = Bon::find($id);
        $bon->delete();
        return response()->json([
            'status' => 200,
            'messages' => 'Berhasil Menghapus Data Bon',
        ]);
    }
}
