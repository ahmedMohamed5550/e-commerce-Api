<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderItemList extends Model
{
    use HasFactory;
    protected $table='order_item_list';
    protected $fillable=[
        'order_id',
        'quntatity',
        'price',
        'product_id',
    ];

    public function order(){
        return $this->BelongsTo(orders::class,'order_id');
    }

    public function product(){
        return $this->BelongsTo(products::class,'product_id');
    }
}
