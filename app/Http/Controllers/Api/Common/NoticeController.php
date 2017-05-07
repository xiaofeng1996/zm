<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\NoticeBaseRepository as Notice;

class NoticeController extends Controller
{
    public function index(Request $request, Notice $notice)
    {
        $this->apiValidate($request, [
            'page' => 'required|integer|min:1'
        ]);
        $notices = $notice->getList($request->userId);
        return response()->api($notices);
    }

    public function read(Request $request, Notice $notice)
    {
        $this->apiValidate($request, [
            'keytype' => 'required|integer',
            'keyid' => 'required|integer'
        ]);
        $notice->read($request->userId, $request->all());
        return response()->api();
    }

    public function delete(Request $request, Notice $notice)
    {
        $this->apiValidate($request, [
            'notice_id' => 'required|integer'
        ]);
        $notice->delete($request->userId, $request->input('notice_id'));
        return response()->api();
    }
}
