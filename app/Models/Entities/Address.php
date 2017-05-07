<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "address";

    protected $fillable = ['user_id', 'name', 'mobile', 'province', 'city', 'district', 'address', 'is_default'];

    protected $hidden = ['user_id', 'updated_at', 'deleted_at'];

}
