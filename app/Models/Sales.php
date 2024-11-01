<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sales';
    protected $guarded = ['id_sales', 'created_at'];
    protected $dates = ['deleted_at'];
}