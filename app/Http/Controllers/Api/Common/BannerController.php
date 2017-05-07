<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Common\BannerRepository as Banner;

class BannerController extends Controller
{
    public function index(Banner $banner)
    {
        $banners = $banner->getBanners();
        return response()->api($banners);
    }

    // banner 图文详情
    public function banner($id)
    {
        return view('api.wap.banner');
    }
}
