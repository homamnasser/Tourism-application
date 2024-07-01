<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class
Trip extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'imgs',
        //'type',
        'cost',
        'starting_date',
        'ending_date',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }}
