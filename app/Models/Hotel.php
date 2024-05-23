<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'price',
        'availability',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
