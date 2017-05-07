<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Html extends Model
{
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = htmlspecialchars($value);
    }

    public function getContentAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }
}
