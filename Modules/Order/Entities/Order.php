<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\City\Entities\City;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['service_number', 'product_id', 'work_id', 'product_price', 'shipping_fees', 'total_price', 'status', 'requester_id', 'provider_id', 'city_from_id', 'city_to_id'];

    /**
     * المنتج المرتبط بالطلب
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * العمل (الخدمة) المرتبط بالطلب
     */
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    /**
     * الدكتور اللي عمل الطلب
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * الفني اللي استلم الطلب
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function city_from()
    {
        return $this->belongsTo(City::class, 'city_from_id');
    }

    public function city_to()
    {
        return $this->belongsTo(City::class, 'city_to_id');
    }
}
