<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'work_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
