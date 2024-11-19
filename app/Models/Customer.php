<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    public $incrementing = false; // Disable auto-incrementing for UUID
    protected $keyType = 'string'; // Set the primary key type to string
    protected $guarded = ['id_customer', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_customer',
        'email_customer',
        'nohp_customer',
        'customer_img',
        'totalpoin_customer'
    ];

    public function getCustomerImgAttribute($value)
    {
        return $value ?: 'default-profile.png'; // Default image jika null atau kosong
    }

    
    protected static function booted()
    {
        static::creating(function ($customer) {
            if (!$customer->id_customer) {
                $customer->id_customer = Str::uuid(); // Menetapkan UUID jika belum ada
            }
        });
    }

}