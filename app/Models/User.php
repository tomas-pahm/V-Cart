<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';                   
    protected $primaryKey = 'user_id';            
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];

public function cartItems()
{
    return $this->hasMany(CartItem::class, 'user_id', 'user_id');
}


public function wishlists()
{
    return $this->hasMany(Wishlist::class, 'user_id', 'user_id');
}

public function wishlistProducts()
{
    return $this->hasManyThrough(
        Product::class,
        Wishlist::class,
        'user_id',    
        'product_id',  
        'user_id',      
        'product_id'    
    );
}


}