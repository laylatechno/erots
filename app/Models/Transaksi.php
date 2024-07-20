<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $guarded = [];
    
     // Definisikan relasi ke model User
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     // Definisikan relasi ke model Produk
     public function produk()
     {
         return $this->belongsTo(Produk::class);
     }

 
}
