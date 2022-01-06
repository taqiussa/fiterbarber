<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keterangan;

class KeteranganController extends Controller
{
    public function index()
    {
        return view('pages.keterangan.keterangan-data', [
            'keterangan' => Keterangan::class
        ]);
    }
    public function indexapi()
    {
        $keterangans = Keterangan::all();
        return response()->json([
            'status' => 200,
            'keterangans' => $keterangans
        ]);
    }
    public function showapi($id){
        $keterangans = Keterangan::find($id);
        return response()->json([
            'keterangans' => $keterangans,
            'status' => 200
        ]);
    }
}
