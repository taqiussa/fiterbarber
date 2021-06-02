<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Pemasukan extends Model
{
    use HasFactory;
    protected $table = 'pemasukan';
    protected $fillable = ['tanggal', 'pegawai_id', 'keterangan_id', 'jumlah', 'harga', 'total', 'komentar', 'vocer'];

    public function getTanggalPemasukanAttribute()
    {
        return Carbon::parse($this->attributes['tanggalpemasukan'])->translatedFormat('l, d M y');
    }
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('pegawai.nama', 'like', '%' . $query . '%')
            ->orWhere('keterangan.namaket', 'like', '%' . $query . '%')
            ->orWhere('pemasukan.komentar', 'like', '%' . $query . '%');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function keterangan()
    {
        return $this->belongsTo(Keterangan::class);
    }
    // public static function pemasukanjoin()
    // {
    //     return DB::table('pemasukan')
    //         ->join('pegawai', 'pemasukan.pegawai_id', '=', 'pegawai.id')
    //         ->join('keterangan', 'pemasukan.keterangan_id', '=', 'keterangan.id')
    //         ->select('pemasukan.*', 'pegawai.nama', 'keterangan.namaket')
    //         ->get();
    // }
}
