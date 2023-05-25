<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couriers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'type', 'price', 'coverage', 'status'
    ];
}