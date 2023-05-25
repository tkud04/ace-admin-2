<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'img', 'subtitle', 'title', 'copy', 'status'
    ];
    
}
