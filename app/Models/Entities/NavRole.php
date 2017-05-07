<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class NavRole extends Model
{
    public function nav()
    {
        return $this->hasOne('Entities\Nav', 'id', 'nav_id');
    }
}
