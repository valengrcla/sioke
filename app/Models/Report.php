<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'sales'; // Menentukan tabel yang digunakan
    protected $primaryKey = 'id_nota'; // Menentukan primary key
    protected $fillable = ['id_customer', 'total_harga', 'created_at'];

    // Relasi dengan tabel customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    // Relasi dengan detail sales
    public function details()
    {
        return $this->hasMany(Detail_sales::class, 'id_nota', 'id_nota');
    }
}
