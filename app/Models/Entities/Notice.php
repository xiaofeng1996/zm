<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    //
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $hidden = ['updated_at', 'deleted_at'];
}
