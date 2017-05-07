<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pay extends Model
{
    use softDeletes;

    public $timestamps = false;
}
