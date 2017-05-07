<?php

namespace App\Http\Controllers\admin\Banner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Admin\Banner\BannerRepository as Banner;

class BannerController extends Controller
{
    public function index(Request $request, Banner $banner)    
    {
        $list = $banner->getBanners();
        return response()->api($list);
    }
}
