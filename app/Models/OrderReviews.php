<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReviews extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'reference', 'caa', 'daa', 'caa_img', 'rating', 'comment', 'status'
    ];
    
}
