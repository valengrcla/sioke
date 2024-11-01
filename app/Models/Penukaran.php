<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penukaran extends Model
{
    use HasFactory;
    protected $table = 'penukaran';
    protected $guarded = ['id_penukaran', 'created_at'];
}