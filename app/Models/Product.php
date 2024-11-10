<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id_product', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_product',
        'harga_product',
        'harga_poinproduct',
        'product_img',
    ];
    
    protected static function booted()
    {
        static::creating(function ($product) {
            if (!$product->id_product) {
                $product->id_product = Str::uuid(); // Menetapkan UUID jika belum ada
            }
        });
    }

}