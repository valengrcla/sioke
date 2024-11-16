<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

 
class Sales extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
 
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
 
    public function detail_sales()
    {
        return $this->hasMany(Detail_sales::class, 'id_nota', 'id_nota');
    }
 
    use HasFactory;
    protected $table = 'sales';
    protected $primaryKey = 'id_nota';
    public $incrementing = false; // Non-increment karena UUID
    protected $keyType = 'string'; // Primary key bertipe string
    protected $guarded = ['id_nota'];
    // protected $casts = [
    //     'id_nota' => 'string',
    // ];
 
    public $timestamps = true;
    protected $fillable = [
        'id_nota', 
        'id_pengguna', 
        'id_customer', 
        'total_harga', 
        'total_pembayaran', 
        'total_kembali',
    ];
 
    // Jika Anda hanya ingin memiliki kolom created_at dan tidak updated_at,
    // Anda dapat mengatur setUp agar mengabaikan updated_at.
    public function setUpdatedAt($value)
    {
        // Jangan mengisi updated_at
    }
 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 
    // protected static function booted()
    // {
    //     static::creating(function ($sales) {
    //         if (empty($sales->id_nota)) {
    //             $sales->id_nota = (string) Str::uuid(); // Menetapkan UUID jika belum ada
    //         }
    //     });
    // }

    protected static function booted()
    {
        static::creating(function ($sales) {
            if (empty($sales->id_nota)) {
                $sales->id_nota = (string) Str::uuid(); // Generate UUID jika belum ada
            }
            //Log::info('UUID Generated: ' . $sales->id_nota);
        });
    }
 
}