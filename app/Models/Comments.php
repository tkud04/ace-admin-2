<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'deal_id', 'user_id', 'comment', 'status'
    ];
    
}
