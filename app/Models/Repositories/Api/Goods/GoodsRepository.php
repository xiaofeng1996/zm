<?php

namespace Repositories\Api\Goods;

use Entities\Category;
use Entities\Goods;
use Entities\GoodsAttr;
use Entities\User;
use JWTAuth;
use DB;
use Repositories\CommentBaseRepository;

class GoodsRepository 
{
    public function getList($data)
    {
        $userId = $this->getUserId($data);

        switch ($data['keytype']) {
            case 1: // 获取首页幸运区商品列表
                $list = $this->getListAboutLuckyRecommend();
                break;
            case 2: // 获取幸运区全部商品
                $list = $this->getListAboutLucky();
                break;
            case 3: // 获取首页会员推荐商品列表
                $list = $this->getListAboutMemberRecommend();
                break;
            case 4: // 根据类别获取商品列表
                $list = $this->getListByCategory($data);
                break;
            case 5: // 获取搜索商品列表(普通商品)
                $list = $this->getListByKeyword($data, 0);
                break;
            case 6: // 获取搜索商品列表(幸运区商品)
                $list = $this->getListByKeyword($data, 1);
                break;
            case 7: // 获取普通商品收藏列表
                $list = $this->getListAboutCollect($userId, 0);
                break;
            case 8: // 获取幸运区商品收藏列表
                $list = $this->getListAboutCollect($userId, 1);
                break;
            case 9: //  获取商家商品列表
                $list = $this->getListAboutMerchant($data['keyid']);
                break;
            default:
                $list = [];
                break;
        }
        
        return $list;
        
    }

    public function getOne($data)
    {
        // DB::enableQueryLog();
        $user_id = $this->getUserId($data);
        $goods = Goods::with('images', 'attrCategorys', 'merchant')
                        ->withCount(['collects as user_collect' => function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }])
                        ->reviewed()
                        ->find($data['goods_id']);
        if (!$goods) {
            throw new \Exception('商品不存在');
        }

        foreach ($goods->attrCategorys as $key => $category) {
            $attr_name = $category->attr_name;
            $values = GoodsAttr::where('goods_id', $category->goods_id)
                                ->groupBy($attr_name)
                                ->select($attr_name . ' as value')
                                ->get();
            $goods->attrCategorys[$key]->values = $values;
        }

        // 添加评论统计相关信息
        $comments = $this->getLastCommentsByGoodsId($data['goods_id']);
        
        $goods->comments = $comments;
        
        // dd(DB::getQueryLog());

        return $goods;
    }

    // 幸运区首页推荐列表
    private function getListAboutLuckyRecommend()
    {
        $list = Goods::where([
                        ['is_lucky', 1],
                        ['recommend', 1]
                    ])
                    ->orderBy('sort')
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->reviewed()
                    ->get();
        return $list;
    }

    // 幸运区全部列表
    private function getListAboutLucky()
    {
        $list = Goods::where('is_lucky', 1)
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return page_helper($list);
    }

    // 会员商品首页推荐
    private function getListAboutMemberRecommend()
    {
        $list = Goods::where([
                            ['is_lucky', 0],
                            ['recommend', 1]
                        ])
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return page_helper($list);
    }

    // 会员商品按类别获取
    private function getListByCategory($data)
    {
        $list = Goods::where([
                            ['is_lucky', 0],
                            ['category_id', $data['category']]
                        ])
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return page_helper($list);
    }

    // 商品搜索获取
    private function getListByKeyword($data, $is_lucky = 0)
    {
        $list = Goods::where([
                            ['is_lucky', $is_lucky],
                            ['name', 'like', '%' . $data["keyword"] . '%']
                        ])
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return page_helper($list);
    }

    // 商品收藏列表 
    private function getListAboutCollect($userId, $isLucky)
    {
        if (!$userId) {
            throw new \Exception('请先登录');
        }

        $user = User::find($userId);
        // DB::enableQueryLog();
        $list = $user->goodsCollects()
                    ->join('goods', function ($join) use ($isLucky) {
                        $join->on('collects.goods_id', '=', 'goods.id')
                                ->where('is_lucky', $isLucky)
                                ->where('review_status', 1);
                    })
                    ->paginate(20);
        // dd(DB::getQueryLog());
        return page_helper($list);
    }

    // 商家商品
    private function getListAboutMerchant($merchant_id)
    {
        $list = Goods::where([
                ['merchant_id', $merchant_id],
                ['is_lucky', 0]
            ])
            ->reviewed()
            ->paginate(20);
        return page_helper($list);
    }

    private function getUserId($data)
    {
        try {
            if (isset($data['token']) && $data['token']) {
                $user = JWTAuth::parseToken()->authenticate();
                return $user->id;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    // 根据商品 id 获取最新两条评论
    private function getLastCommentsByGoodsId($goods_id)
    {
        $comments = new \stdClass();

        $comment_repo = new CommentBaseRepository;
        $total_count = $comment_repo->getTotalCountByGoodsId($goods_id);
        $good_count = $comment_repo->getGoodCountByGoodsId($goods_id);
        $good_rate = $comment_repo->getGoodRateAboutGoods($total_count, $good_count);
        $last_comments = $comment_repo->getLastComments($goods_id);

        $comments->total_count = $total_count;
        $comments->good_rate = $good_rate;
        $comments->list = $last_comments;

        return $comments;
    }

}
