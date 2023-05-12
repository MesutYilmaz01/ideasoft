<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $casts = [
        'since' => 'datetime:Y/m/d'
    ];

    protected $fillable = [
        'name', 'since', 'revenue'
    ];
}
