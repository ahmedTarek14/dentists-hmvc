<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'shipping_fees'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
