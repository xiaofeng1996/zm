<?php

namespace Repositories\Api\Common;

use Entities\Banner;

class BannerRepository 
{
    public function getBanners()
    {
        $banners = Banner::where('active', 1)
                        ->orderBy('sort')
                        ->select('id', 'keytype', 'keyid', 'image', 'sort', 'link')
                        ->get();
        return $banners;
    }
}
