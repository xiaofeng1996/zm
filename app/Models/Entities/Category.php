<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categorys';

    protected $hidden = ['updated_at', 'deleted_at'];

    public function children()
    {
        return $this->hasMany('Entities\Category', 'parent_id', 'id');
    }
}
