<?php

namespace Repositories\Admin\Banner;

use Entities\Banner;
use Carbon\Carbon;
use DB;

class BannerRepository 
{
    public function getBanners()
    {
        $list = Banner::get();
        return $list;
    }

    public function create($data)
    {
        Banner::insert([
            'keytype' => $data['keytype'],
            'keyid' => $data['keyid'],
            'sort' => $data['sort'],
            'image' => $data['image'],
            'image_web' => $data['image_web'],
            'link' => $data['link'],
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
    public function update($data)
    {
        $banner = Banner::find($data['id']);
        if (!$banner) {
            throw new \Exception('改广告不存在');
        }
        $banner->keytype = $data['keytype'];
        $banner->keyid = $data['keyid'];
        $banner->sort = $data['sort'];
        $banner->image = $data['image'];
        $banner->image_web = $data['image_web'];
        $banner->link = $data['link'];
        $banner->active = 1;
        $banner->updated_at = Carbon::now();

        $banner->save();
    }
    public function delete($id)
    {
        Banner::where('id', $id)->delete();
    }
}
