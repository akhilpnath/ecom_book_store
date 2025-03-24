<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory, Cachable;

    protected $fillable = [
        'name',
        'category',
        'details',
        'price',
        'image',
        'authors',
        'language',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            // Cache::tags(['products'])->flush();
            cache()->forget('categories_list');
            cache()->forget('products_list');
        });

        static::updated(function () {
            // Cache::tags(['products'])->flush();
            cache()->forget('categories_list');
            cache()->forget('products_list');
        });
        static::deleted(function () {
            // Cache::tags(['products'])->flush();
            cache()->forget('categories_list');
            cache()->forget('products_list');
        });
        static::saved(function () {
            // Cache::tags(['products'])->flush();
            cache()->forget('categories_list');
            cache()->forget('products_list');
        });
    }
}