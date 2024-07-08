<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class orders extends Model
{
    use HasFactory;
    protected $table="orders";
    protected $fillable=[
        'status',
        'user_id',
        'location_id',
        'total_price',
        'date_of_delivery',
    ];

    public function user(){
        return $this->BelongsTo(User::class,'user_id');
    }

    public function location(){
        return $this->BelongsTo(location::class,'location_id');
    }

    public function items(){
        return $this->hasMany(orderItemList::class);
    }
}
