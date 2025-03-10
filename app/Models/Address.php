<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory,Cachable;
    
    protected $primaryKey = 'id';
    protected $table = 'address';
    protected $fillable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'pincode',
        'phone_number',
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}