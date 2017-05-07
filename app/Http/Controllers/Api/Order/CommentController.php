<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Order\CommentRepository as Comment;

class CommentController extends Controller
{
    public function create(Request $request, Comment $comment)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer',
            'star' => 'required|integer|min:0|max:5',
            'content' => 'required|string|max:120'
        ]);
        $comment_id = $comment->create($request->userId, $request->all());
        return response()->api(['comment_id' => $comment_id]);
    }

    public function index(Request $request, Comment $comment)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer'
        ]);
        $comments = $comment->getCommentsByGoodsId($request->input('goods_id'));
        return response()->api($comments);
    }

}
