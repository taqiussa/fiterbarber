<?php

namespace App\Http\Controllers;

use App\Models\Harga;

class HargaController extends Controller
{
    public function showapi($pegawai, $keterangan)
    {
        $harga = Harga::where('pegawai_id',$pegawai)->where('keterangan_id',$keterangan)->first();
        return response()->json([
            'harga' => $harga,
            'status' => 200,
        ]);
    }

}
