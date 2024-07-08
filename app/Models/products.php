<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table="products";
    protected $fillable=[
        'category_id',
        'brand_id',
        'name',
        'is_trendy',
        'is_available',
        'price',
        'amount',
        'discount',
        'image'
    ];

    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }

    public function brands(){
        return $this->belongsTo(brands::class,'brand_id');
    }
}
