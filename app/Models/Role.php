<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $guarded = ['id_role'];
    protected $casts = [
        'id_role' => 'string',
    ];
    protected $fillable = ['nama_role'];

    public function pengguna()
    {
        // Menghubungkan foreign key di tabel pengguna ('id_role') dengan local key di tabel role ('id')
        return $this->hasMany(Pengguna::class, 'id_role');
    }
}