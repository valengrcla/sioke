<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Pengguna extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $guarded = ['id_pengguna', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'nama_pengguna',
        'username',
        'password',
        'user_img',
        'id_role',
    ];
    
    protected static function booted()
    {
        static::creating(function ($pengguna) {
            if (!$pengguna->id_pengguna) {
                $pengguna->id_pengguna = Str::uuid(); // Menetapkan UUID jika belum ada
            }
        });
    }
    
    protected function casts(): array
    {
        return [
            'id_pengguna'=> 'string',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role'); 
    }
}