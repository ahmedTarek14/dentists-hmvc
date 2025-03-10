<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ImageTrait;
use Modules\Order\Entities\Order;
use Modules\User\Entities\Rating;

class Product extends Model
{
    use HasFactory, ImageTrait;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'quantity',
    ];

    public function getImagePathAttribute()
    {
        return $this->get_image($this->image, 'products');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}