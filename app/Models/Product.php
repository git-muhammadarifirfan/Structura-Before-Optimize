<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'image',
        'product_name',
        'sku',
        'price',
        'stock',
        'status',
        'brand',
        'color',
        'size',
        'weight',
        'description',
        'category_id',
        'user_id',
    ];

    protected static function booted()
    {
        static::created(function ($product) {
            $productName = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $product->product_name), 0, 3));
            if (strlen($productName) < 3) {
                $productName = str_pad($productName, 3, 'X'); // fallback jika kurang dari 3 huruf
            }

            $category = $product->category()->first();
            $categoryCode = $category ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $category->category_name), 0, 3)) : 'GEN';
            if (strlen($categoryCode) < 3) {
                $categoryCode = str_pad($categoryCode, 3, 'X');
            }

            $formattedId = str_pad($product->id, 5, '0', STR_PAD_LEFT);

            $sku = "{$productName}-{$categoryCode}-{$formattedId}";

            $product->withoutEvents(function () use ($product, $sku) {
                $product->update(['sku' => $sku]);
            });
        });
    }


    // Relasi: Produk hanya punya satu Kategori
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relasi: 1 Produk bisa ada di banyak cart
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
