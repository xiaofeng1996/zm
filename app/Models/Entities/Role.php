<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    public function nav_roles()
    {
        return $this->hasMany('Entities\NavRole');
    }
}