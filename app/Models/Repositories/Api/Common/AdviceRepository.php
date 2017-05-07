<?php

namespace Repositories\Api\Common;

use Carbon\Carbon;
use DB;

class AdviceRepository 
{
    public function create($data)
    {  
        DB::table('advices')->insert([
            'content' => $data['content'],
            'device' => $data['device'],
            'created_at' => Carbon::now()
        ]);
    }
}
