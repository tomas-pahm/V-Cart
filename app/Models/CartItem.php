<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cartitem';
    protected $primaryKey = 'cart_item_id'; 
    public $incrementing = true;       
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'product_id');                              
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}
}