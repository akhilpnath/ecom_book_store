<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,Cachable;

    protected $fillable = [
        'user_id',
        'name',
        'number',
        'email',
        'method',
        'address',
        'total_products',
        'total_price',
        'placed_on',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}