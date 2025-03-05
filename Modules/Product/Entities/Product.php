<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ImageTrait;

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
}