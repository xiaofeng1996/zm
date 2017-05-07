<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $hidden = ['imageable_type', 'created_at', 'updated_at'];

    public function imageable()
    {
        return $this->morphTo();
    }

}
