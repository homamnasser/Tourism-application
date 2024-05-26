<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'food_type',
        'description',
        'price',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
