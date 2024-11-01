<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengguna extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pengguna';
    protected $guarded = ['id_pengguna', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}