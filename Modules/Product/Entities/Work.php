<?php

namespace Modules\Product\Entities;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\User\Entities\Rating;

class Work extends Model
{
    use HasFactory, ImageTrait;

    protected $fillable = ['technician_id', 'title', 'description', 'price', 'image'];

    public function getImagePathAttribute()
    {
        return $this->get_image($this->image, 'works');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
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
