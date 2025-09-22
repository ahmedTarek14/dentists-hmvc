<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\City\Entities\City;
use Modules\City\Entities\District;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Work;
use Modules\User\Entities\Rating;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['service_number', 'product_id', 'work_id', 'product_price', 'shipping_fees', 'total_price', 'status', 'requester_id', 'provider_id', 'city_from_id', 'city_to_id', 'district_from_id', 'district_to_id', 'address', 'more_info'];

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

    public function district_from()
    {
        return $this->belongsTo(District::class, 'district_from_id');
    }

    public function district_to()
    {
        return $this->belongsTo(District::class, 'district_to_id');
    }

    // الدكتور بيريت العمل أو المنتج المرتبط بالأوردر
    public function doctorRating()
    {
        return $this->hasOne(Rating::class, 'user_id', 'requester_id')
            ->when($this->work_id, function ($q) {
                $q->where('work_id', $this->work_id);
            })
            ->when($this->product_id, function ($q) {
                $q->where('product_id', $this->product_id);
            });
    }

    // الفني بيريت الدكتور صاحب الطلب
    public function technicianRating()
    {
        return $this->hasOne(Rating::class, 'user_id', 'provider_id')
            ->where('rated_user_id', $this->requester_id);
    }
}
