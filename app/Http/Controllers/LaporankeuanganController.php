<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporankeuanganController extends Controller
{
    public function index()
    {
        return view('pages.laporan.laporankeuangan-data');
    }
    public function indexapi($bulan, $tahun){
        $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('total');
        $pengeluaran = Pengeluaran::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('total');
        $bon = Bon::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah');
        $saldo = intval($pemasukan) - (intval($pengeluaran) + intval($bon));
        return response()->json([
            'status' => 200,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'bon' => $bon,
            'saldo' => $saldo,
        ]);
    }
    public function dashboardapi(){
        $total = Pemasukan::whereMonth('tanggal', date('m'))->whereYear('tanggal',date('Y'))->sum('total');
        $totalpengeluaran = Pengeluaran::whereMonth('tanggal', date('m'))->whereYear('tanggal',date('Y'))->sum('total');
        $saldo = intval($total) - intval($totalpengeluaran);
        $fendi = Pemasukan::
                whereMonth('tanggal', date('m'))
                ->whereYear('tanggal',date('Y'))
                ->where('pegawai_id',1)
                ->get();
        $bayu = Pemasukan::
                whereMonth('tanggal', date('m'))
                ->whereYear('tanggal',date('Y'))
                ->where('pegawai_id',2)
                ->get();
        $budi = Pemasukan::
                whereMonth('tanggal', date('m'))
                ->whereYear('tanggal',date('Y'))
                ->where('pegawai_id',3)
                ->get();
        return response()->json([
            'total' => $total,
            'totalpengeluaran' => $totalpengeluaran,
            'saldo' => $saldo,
            'fendi' => $fendi,
            'bayu' => $bayu,
            'budi' => $budi,
        ]);
    
    }
}
