<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $guarded = ['id_product', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}