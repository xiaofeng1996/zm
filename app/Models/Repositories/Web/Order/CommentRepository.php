<?php

namespace Repositories\Web\Order;

use Entities\Comment;
use Entities\OrderGoods;
use Entities\Order;
use Entities\Image;
use DB;
use Carbon\Carbon;

class CommentRepository 
{

    private $order_goods = null;

    public function isAllowComment($user_id, $order_goods_id)
    {
        $order_goods = $this->getOrderGoods($order_goods_id);
        return ($order_goods
                && $order_goods->order
                && $order_goods->order->user_id == $user_id
                && $order_goods->is_comment == 0)
                ? true
                : false;
    }

    public function store($user_id, $data)
    {
        $order_goods = $this->getOrderGoods($data['order_goods_id']);
        $comment_id = 0;
        DB::transaction(function () use ($user_id, $data, $order_goods, &$comment_id) {
            $comment_id = Comment::insertGetId([
                'user_id'       => $user_id,
                'order_id'      => $data['order_id'],
                'goods_id'      => $order_goods->goods_attr->goods_id,
                'content'       => $data['content'],
                'star'          => $data['star'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);

            $order_goods->is_comment = 1;
            $this->order_goods = $order_goods;
            $order_goods->save();

        });

        return $comment_id;

    }

    public function storeImg($comment_id, $request)
    {
        $data = [];
        for ($i = 0; $i < 4; $i++) {
            if ($request->hasFile('file' . $i)) {
                $path = '/storage/' . $request->{'file'.$i}->store('images', 'public');
                $data[] = [
                    'imageable_type'    => 'Entities\Comment',
                    'imageable_id'      => $comment_id,
                    'image'             => $path,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ];

            }
        }
        Image::insert($data);
    }

    // private function getOrder($user_id, $order_id)
    // {
    //     if (!$this->order) {
    //         $order = Order::where([
    //             ['user_id', $user_id],
    //             ['id', $order_id]
    //         ])->first();
    //         $this->order = $order;
    //     } else {
    //         $order = $this->order;
    //     }
    //     return $order;
    // }

    private function getOrderGoods($order_goods_id)
    {
        if (!$this->order_goods) {
            $order_goods = OrderGoods::with('goods_attr', 'order')->find($order_goods_id);
            $this->order_goods = $order_goods;
        } else {
            $order_goods = $this->order_goods;
        }
        return $order_goods;
    }
}