<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDetails extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'company', 'zipcode', 'state', 'address', 'city'
    ];
}
