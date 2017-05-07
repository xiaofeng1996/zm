<?php

namespace Repositories\Admin;

use DB;
use Entities\Goods;
use App\Exceptions\ApiException;

class ProductRepository 
{
    public function getProducts($request)
    {
        $role_id = $request->session()->get('role_id');
        if ($role_id = 1) {
            $products = $this->getProductsByAdmin($request);
        } else {
            $products = $this->getProductsByMerchant($request);
        }
        return $products;
    }

    /**
     * 系统管理员获取商品
     */
    private function getProductsByAdmin($request)
    {
        $products = Goods::
    }

     /**
      * 商家管理员获取商品列表
      */
    private function getProductsByMerchant($request)
    {

    }
}

