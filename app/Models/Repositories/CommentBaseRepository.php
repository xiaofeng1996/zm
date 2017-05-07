<?php

namespace Repositories;

use Entities\Comment;

class CommentBaseRepository 
{
    public function getCommentsByGoodsId($goods_id)
    {

        $return = new \stdClass();

        $comments = Comment::with('user', 'images')
                            ->where('goods_id', $goods_id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);
        $comments = page_helper($comments);

        // $total_count = $this->getTotalCountByGoodsId($goods_id);
        // $good_count = $this->getGoodCountByGoodsId($goods_id);
        // $good_rate = $this->getGoodRateAboutGoods($total_count, $good_count);

        // $return->total_count = $total_count;
        // $return->good_rate = $good_rate;
        // $return->comments = $comments;

        // return $return;
        return $comments;
    }
    
    // 获取最新几条评论
    public function getLastComments($goods_id, $count = 2)
    {
        $comments = Comment::with('user', 'images')
                            ->where('goods_id', $goods_id)
                            ->orderBy('created_at', 'desc')
                            ->limit(2)
                            ->get();
        return $comments;
    }

    // 评价总数
    public function getTotalCountByGoodsId($goods_id)
    {
        $count = Comment::where('goods_id', $goods_id)->count();
        return $count;
    }

    // 好评数
    public function getGoodCountByGoodsId($goods_id)
    {
        $good_count = Comment::where([
            ['goods_id', $goods_id],
            ['star', '=', 5]
        ])->count();
        return $good_count;
    }

    // 好评率
    public function getGoodRateAboutGoods($total_count, $good_count)
    {
        if ($total_count > 0) {
            return round(($good_count / $total_count) * 100) . '%'; 
        } else {
            return '100%';
        }
    }

}