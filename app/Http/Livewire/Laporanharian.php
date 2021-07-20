<?php

namespace App\Http\Livewire;

use App\Models\Pegawai;
use Livewire\Component;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;

class Laporanharian extends Component
{
    public $tanggalmulai;
    public $tanggalakhir;
    public $pilihlaporan;
    public $pemasukans;
    public $pengeluarans;
    public $jumlahtotal;
    public $isPemasukan = 0;
    public $isPengeluaran = 0;

    public function mount()
    {
        $this->tanggalmulai = gmdate('Y-m-d');
        $this->tanggalakhir = gmdate('Y-m-d');
    }
    public function render()
    {
        if(!empty($this->pilihlaporan)){
            $this->pemasukans = Pemasukan::whereBetween('created_at',[$this->tanggalmulai,$this->tanggalakhir])
            ->where('pegawai_id',$this->pilihlaporan)
            ->select(
                'tanggal as tanggalpemasukan',
                'jumlah',
                'total',
            )
            ->get();
            $this->jumlahtotal =  Pemasukan::whereBetween('created_at',[$this->tanggalmulai,$this->tanggalakhir])
            ->where('pegawai_id',$this->pilihlaporan)->sum('total');
            $this->isPemasukan = true;
        }
        $data =[
            'pegawai' => Pegawai::orderBy('nama')->get(),
            'pemasukanss' => $this->pemasukans,
        ];
        return view('livewire.laporan.laporanharian', $data);
    }
}
