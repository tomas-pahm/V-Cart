<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name',
    ];
    public $timestamps = true;

    // ================= QUAN HỆ NGƯỢC LẠI =================
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}