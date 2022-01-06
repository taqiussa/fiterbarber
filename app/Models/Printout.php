<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Printout extends Model
{
    use HasFactory;
    protected $table = 'prints';
    protected $fillable = ['tanggal_mulai', 'tanggal_akhir', 'jumlah', 'total'];
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d M y');
    }
    public function getTanggalMulaiAttribute()
    {
        return Carbon::parse($this->attributes['tanggal_mulai'])->translatedFormat('l, d M y');
    }
    public function getTanggalAkhirAttribute()
    {
        return Carbon::parse($this->attributes['tanggal_akhir'])->translatedFormat('l, d M y');
    }
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('jumlah', 'like', '%' . $query . '%');
    }
}
