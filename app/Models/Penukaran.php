<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Penukaran extends Model
{
    use HasFactory;
    protected $table = 'penukaran';
    protected $primaryKey = 'id_penukaran';
    public $timestamps = true;  // Aktifkan timestamps (jika ingin menggunakan created_at)
    const UPDATED_AT = null;
    protected $guarded = ['id_penukaran', 'created_at'];

    protected static function booted()
    {
        static::creating(function ($penukaran) {
            if (!$penukaran->id_penukaran) {
                $penukaran->id_penukaran = Str::uuid();  // Menetapkan UUID jika belum ada
            }
        });
    }
}