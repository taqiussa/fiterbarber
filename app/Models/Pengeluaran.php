<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $fillable = ['tanggal', 'keterangan', 'total','tanggalsimpan'];
    public function getTglAttribute()
    {
        return Carbon::parse($this->attributes['tgl'])->translatedFormat('l, d M y');
    }
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d M y');
    }
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('keterangan', 'like', '%' . $query . '%');
    }
}
