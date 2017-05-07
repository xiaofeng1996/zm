<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\OrderGoods;
use Repositories\Web\Order\CommentRepository as Comment;

class CommentController extends Controller
{
    public function create($order_goods_id, Request $request)
    {
        $order_goods = OrderGoods::with('goods_attr')->find($order_goods_id);
        return view('web.order.comment')->with('order_goods', $order_goods);
    }

    public function store(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'order_id'          => 'required|integer|min:1',
            'order_goods_id'    => 'required|integer|min:1',
            'star'              => 'required|integer|min:0|max:5',
            'content'           => 'required'
        ]);
        $user_id = $request->session()->get('user_id');
        
        if ($comment->isAllowComment($user_id, $request->order_goods_id)) {
            $comment_id = $comment->store($user_id, $request->all());
            $comment->storeImg($comment_id, $request);
        }

        return redirect('/order/' . $request->order_id);

    }
}
