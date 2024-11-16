<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Poin extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer'); 
    }
    use HasFactory;
    protected $table = 'poin';
    protected $primaryKey = 'id_poin';
    public $timestamps = true; // Aktifkan timestamps
    const UPDATED_AT = null;
    protected $guarded = ['id_poin', 'created_at'];
    protected $casts = [
        'id_poin' => 'string',
    ];

    protected static function booted()
    {
        static::creating(function ($poin) {
            if (!$poin->id_poin) {
                $poin->id_poin = Str::uuid(); // Menetapkan UUID jika belum ada
            }
        });
    }
}