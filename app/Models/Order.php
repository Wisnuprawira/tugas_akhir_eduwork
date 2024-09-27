<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $primaryKey = 'or_id';
    protected $fillable = ['or_id','or_pd_id','or_amount'];

    // Relasi ke tabel Produk
        // public function product()
        // {
        //     return $this->belongsTo(Product::class, 'or_pd_id', 'pd_name');
        // }
}
