<?php

namespace Repositories\Api\Order;

use Entities\OrderGoods;
use Entities\Comment;
use Carbon\Carbon;
use Repositories\CommentBaseRepository;

class CommentRepository extends CommentBaseRepository
{
    public function create($user_id, $data)
    {
        $order_goods = OrderGoods::find($data['id']);
        if (!$order_goods) {
            throw new \Exception('订单商品不存在');
        }

        if ($order_goods->order->status != 4) {
            throw new \Exception('订单状态不能评论');
        }

        $comment_id = Comment::insertGetId([
            'user_id' => $user_id, 
            'order_id' => $order_goods->order->id,
            'goods_id' => $order_goods->goods_attr->goods_id,
            'star' => $data['star'],
            'content' => $data['content'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return $comment_id;
    }
}