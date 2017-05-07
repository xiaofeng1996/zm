<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->hasOne('Entities\Role', 'id', 'role_id');
    }

    public function Merchant()
    {
        return $this->hasOne('Entities\Merchant');
    }
}
