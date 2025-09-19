<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'work_id', 'rating', 'comment', 'rated_user_id'];

    // اللي عمل التقييم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // المستخدم اللي التقييم موجه له
    public function ratedUser()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
