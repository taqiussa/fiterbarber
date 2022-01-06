<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pages.pegawai.pegawai-data', [
            'pegawai' => Pegawai::class
        ]);
    }
    public function indexapi(){
        $pegawais = Pegawai::all();
        return response()->json([
            'status' => 200,
            'pegawais' => $pegawais
        ]);
    }
    public function storeapi(Request $request){
        Pegawai::create($request->only([
            'nama',
            'tempat'
        ]));
        return response()->json([
            'messages' => 'Berhasil Menyimpan Data',
            'status' => 200
        ]);
    }
    public function destroyapi($id){
        $pegawai = Pegawai::find($id);
        $pegawai->delete();
        return response()->json([
            'messages' => 'Berhasil Menghapus Data',
            'status' => 200
        ]);
    }
    public function showapi($id){
        $pegawai = Pegawai::find($id);
        return response()->json([
            'pegawais' => $pegawai,
            'status' => 200
        ]);
    }
    public function updateapi(Request $request , $id){
        Pegawai::find($id)->update($request->only([
            'nama',
            'tempat'
        ]));
        return response()->json([
            'messages' => 'Berhasil Update',
            'status' => 200
        ]);
    }
}
