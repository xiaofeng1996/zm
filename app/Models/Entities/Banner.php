<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public function richtext()
    {
        return $this->hasOne('Entities\Html', 'htmlable_id', 'id')
                    ->where('htmlable_type', 'Entities\Banner');
    }

    // public function getLinkAttribute($value)
    // {
    //     return env('APP_URL') . $value;
    // }
}
