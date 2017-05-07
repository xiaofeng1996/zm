<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    // 上传单图片
    public function uploadImage(Request $request)
    {
        if ($request->file->isValid()) {
            $path = $request->file->store('images', 'public');
            return '/storage/' . $path;
        } else {
            return '';
        }
    }
}
