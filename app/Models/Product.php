<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name', 'price', 'description', 'images', 'stock', 'category_id'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    // ================== ĐÂY LÀ PHẦN QUAN TRỌNG NHẤT ==================
    // Giá trong DB là mỗi 100g → hiển thị tự động đúng đơn vị 100g
    public function getPriceAttribute($value)
    {
        return (int) $value;
    }

    public function getPricePerKgAttribute()
    {
        return $this->price * 10;
    }

    public function getUnitAttribute()
    {
        return '100g';
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . '₫ / 100g';
    }

    public function getFormattedPricePerKgAttribute()
    {
        return number_format($this->price * 10) . '₫ / kg';
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit(strip_tags($this->description), 120);
    }

    /**
 * Quan hệ với Category
 */
public function category()
{
    return $this->belongsTo(\App\Models\Category::class, 'category_id', 'category_id');
}
    // ================================================================
     // Product.php

public function wishlistedBy()
{
    return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
}

}