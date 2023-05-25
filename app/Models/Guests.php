<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guests extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'status'
    ];
    
}
