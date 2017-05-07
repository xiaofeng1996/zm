<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Notice;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $notices = Notice::where('user_id', $user_id)->orderBy('created_at', 'desc')->limit(20)->get();
        return view('web.user.notice.index')->with('notices', $notices);
    }

    public function delete($id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        Notice::where([
            ['user_id', $user_id],
            ['id', $id]
        ])->delete();
        return redirect('/notices');
    }
}
