<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];


    public function works()
    {
        return $this->hasMany(User::class, 'type_id');
    }
}
