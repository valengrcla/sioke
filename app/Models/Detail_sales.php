<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Detail_sales extends Model
{
    use HasFactory;
    protected $table = 'detail_sales';
 
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
 
    public $timestamps = false; // Menonaktifkan timestamp otomatis untuk 'updated_at'
 
    // Menetapkan hanya 'created_at' yang digunakan sebagai timestamp
    const CREATED_AT = 'created_at';  // Menggunakan 'created_at' untuk timestamp
    const UPDATED_AT = null;  
   
    protected $fillable = [
        'id_product',
        'subtotal',    
        'quantity',      
        'harga',          
        'id_nota',        
    ];
}