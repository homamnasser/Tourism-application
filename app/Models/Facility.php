<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }

}