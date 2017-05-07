<?php

namespace Entities; 

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile', 'avatar', 'avatar_big', 'password', 'pay_password', 'province', 'city', 'district',
        'openid', 'unionid', 'weiboid', 'idstr', 'qq_openid', 'device'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'pay_password', 'remember_token', 'deleted_at', 'openid', 'unionid', 'weiboid', 'idstr', 'qq_openid'
    ];

    protected $dates = ['deleted_at'];

    public function address()
    {
        return $this->hasMany('Entities\Address');
    }

    public function goodsCollects()
    {
        return $this->hasMany('Entities\Collect');
    }

}
