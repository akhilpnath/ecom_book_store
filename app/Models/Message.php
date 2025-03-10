<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory,Cachable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'number',
        'message',
        'is_read'
    ];

    protected $table='message';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}