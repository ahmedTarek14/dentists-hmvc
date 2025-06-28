<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseUser;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Work;
use Modules\User\Entities\Rating;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * التقييمات المرتبطة بالمستخدم
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
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
}