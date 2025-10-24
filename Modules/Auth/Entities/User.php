<?php

namespace Modules\Auth\Entities;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\City\Entities\City;
use Modules\City\Entities\District;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseUser;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Work;
use Modules\User\Entities\Rating;
use Modules\User\Entities\Type;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'type',
        'password',
        'email_verified_at',
        'status',
        'city_id',
        'district_id',
        'address',
        'image',
        'phone',
        'type_id'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * الطلبات اللي الدكتور عملها (اللي هو requester)
     */
    public function doctorOrders()
    {
        return $this->hasMany(Order::class, 'requester_id');
    }

    /**
     * الطلبات اللي الفني استلمها (اللي هو provider)
     */
    public function providerOrders()
    {
        return $this->hasMany(Order::class, 'provider_id');
    }

    // التقييمات اللي المستخدم كتبها (هو المقيِّم)
    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    // التقييمات اللي اتعملت له (هو المتقيَّم)
    public function receivedRatings()
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    // حساب متوسط التقييمات اللي اتعملت له
    public function averageReceivedRating()
    {
        return $this->receivedRatings()->avg('rating');
    }

    /**
     * الأعمال (الخدمات) اللي الفني مقدمها
     */
    public function works()
    {
        return $this->hasMany(Work::class, 'technician_id');
    }

    // جلب جميع الطلبات اللي تمت على أعمال الفني
    public function workOrders()
    {
        return $this->hasManyThrough(Order::class, Work::class, 'technician_id', 'work_id', 'id', 'id');
    }

    // حساب متوسط التقييمات لأعمال الفني (لو كان فني)
    public function averageRating()
    {
        return $this->works()->with('ratings')->get()->flatMap->ratings->avg('rating');
    }
    //دي ادائها احسن نفس الي قبلها
    //     public function getAverageRatingAttribute()
    // {
    //     return round(
    //         $this->works()
    //             ->join('ratings', 'ratings.work_id', '=', 'works.id')
    //             ->avg('ratings.rating') ?? 0,
    //         1
    //     );
    // }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function getImagePathAttribute()
    {
        return $this->get_image($this->image, 'users');
    }

    public function typeRelation()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}
