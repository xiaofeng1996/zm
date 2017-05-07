<?php

namespace Repositories\Api\Balance;

use Entities\Contact;
use DB;

class ContactRepository 
{
    public function getList($user_id)
    {
        $contacts = Contact::where([
            ['user_id', $user_id],
            ['invite_user_id', '>', 0]
        ])
        ->orderBy('updated_at', 'desc')
        ->paginate(20);
        return $contacts ? page_helper($contacts) : [];
    }
}