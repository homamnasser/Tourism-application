<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
    ];

    public function cites()
    {
        return $this->hasMany(City::class);
    }
}
