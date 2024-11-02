<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengguna extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role'); // Gantilah 'role_id' dengan nama kolom foreign key jika berbeda
    }
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $guarded = ['id_pengguna', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}