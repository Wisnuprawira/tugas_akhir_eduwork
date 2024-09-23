<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'pd_id';

    // public $timestamps = true;

    // protected $fillable = ['pd_id','pd_code','pd_ct_id','pd_name','pd_price',];

    protected $guarded = ['pd_id'];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'pd_ct_id', 'ct_id');
    // }
}
