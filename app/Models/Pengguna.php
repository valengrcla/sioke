<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $guarded = ['id_pengguna', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role'); 
    }
}