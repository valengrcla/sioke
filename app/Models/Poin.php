<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer'); 
    }
    use HasFactory;
    protected $table = 'poin';
    protected $primaryKey = 'id_poin';
    protected $guarded = ['id_poin', 'created_at'];
    protected $casts = [
        'id_poin' => 'string',
    ];
}