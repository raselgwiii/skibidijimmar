<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageUrlAttribute($value)
    {
        if (!$value || !file_exists(public_path($value))) {
            return asset('images/no-image.png');
        }
        return asset($value);
    }

    public function getRawOriginal($key = null, $default = null)
    {
        return parent::getRawOriginal($key, $default);
    }
}