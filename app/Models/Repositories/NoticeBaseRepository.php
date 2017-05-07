<?php

namespace Repositories;

use Entities\Notice;

class NoticeBaseRepository 
{
    public function getList($user_id)
    {
        $notices = Notice::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(20);
        return page_helper($notices);
    }
    
    public function read($user_id, $data)
    {
        $keytype = $data['keytype'];
        switch ($keytype) {
            case 1:
                Notice::where([
                    ['user_id', $user_id],
                    ['is_read', 0]
                ])
                ->update(['is_read' => 1]);
                break;
            case 2:
                Notice::where([
                    ['user_id', $user_id],
                    ['id', $data['keyid']]
                ])
                ->update(['is_read' => 1]);
                break;
            default:
                break;
        }
        return;
    }

    public function delete($user_id, $notice_id)
    {
        Notice::where([
            ['user_id', $user_id],
            ['id', $notice_id]
        ])->delete();
    }
}