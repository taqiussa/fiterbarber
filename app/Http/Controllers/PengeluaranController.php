<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        return view('pages.transaksi.pengeluaran-data', [
            'pengeluaran' => Pengeluaran::class
        ]);
    }
    public function indexapi()
    {
        $pengeluarans = Pengeluaran::orderBy('tanggal','desc')->orderBy('created_at','desc')->get();
        return response()->json([
            'status' => 200,
            'pengeluarans' => $pengeluarans,
        ]);
    }
    public function showapi($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        return response()->json([
            'pengeluaran' => $pengeluaran,
            'status' => 200,
        ]);
    }
    public function updateapi(Request $request, $id)
    {
        Pengeluaran::find($id)->update($request->only([
            'tanggal',
            'keterangan',
            'total',
            ]));
        return response()->json([
            'messages' => 'Berhasil Update',
            'status' => 200
        ]);
    }
    public function storeapi(Request $request)
    {
        Pengeluaran::create($request->only([
            'tanggal',
            'keterangan',
            'total',
        ]));
        return response()->json([
            'messages' => 'Berhasil Menyimpan Data Pemasukan',
            'status' => 200
        ]);
    }
    public function destroyapi($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();
        return response()->json([
            'messages' => 'Berhasil Menghapus Data',
            'status' => 200
        ]);
    }
}
