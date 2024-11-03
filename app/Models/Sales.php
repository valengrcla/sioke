<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer'); 
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna'); 
    }

    public function detail_sales()
    {
        return $this->belongsTo(Detail_sales::class, 'id_nota', 'id_nota'); 
    }

    use HasFactory;
    protected $table = 'sales';
    protected $primaryKey = 'id_nota';
    protected $guarded = ['id_nota', 'created_at'];
    protected $casts = [
        'id_nota' => 'string',
    ];
}