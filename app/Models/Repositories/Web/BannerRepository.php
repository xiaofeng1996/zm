<?php

namespace Repositories\Web;

use Entities\Banner;

class BannerRepository 
{
    public function getBanners()
    {
        $banners = Banner::orderBy('sort')->get();
        return $banners;
    }
}