<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pemasukan;

class LaporanpemasukanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.laporanpemasukan-data');
    }
    public function harian()
    {
        return view('pages.laporan.laporanharian-data', [
            'laporanharian' => Pemasukan::class
        ]);
    }
}
