<?php

namespace Repositories\Api\Common;

use Entities\User;
use Entities\Image;
use Carbon\Carbon;

class FileRepository 
{
    public function store($request)
    {
        $keytype = $request->keytype;
        switch ($keytype) {
            case 1: // 上传头像
                $user_id = $request->userId;
                if ($request->file->isValid()) {
                    $path = $request->file->store('images', 'public');
                    User::where('id', $user_id)->update(['avatar' => $path]);
                }
                break;
            case 2:
                if ($request->file->isValid()) {
                    $path = $request->file->store('images', 'public');
                    Image::insert([
                        'imageable_type' => 'Entities\OrderService',
                        'imageable_id' => $request->input('keyid'),
                        'image' => $path,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                break; 
            case 3: // 评论图片
                if ($request->file->isValid()) {
                    $path = $request->file->store('images', 'public');
                    Image::insert([
                        'imageable_type' => 'Entities\Comment',
                        'imageable_id' => $request->input('keyid'),
                        'image' => $path,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                break;
            default:
                throw new \Exception('文件上传错误');
                break;
        }

        return $path ? $path : '';

    }
}
