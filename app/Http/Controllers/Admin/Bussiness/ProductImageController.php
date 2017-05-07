<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Image;

class ProductImageController extends Controller
{
    public function index($goods_id)
    {
        $images = Image::where([
            ['imageable_type', 'Entities\Goods'],
            ['imageable_id', $goods_id]
        ])
        ->orderBy('sort', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->api($images);
    }

    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'goods_id'  => 'required|integer'
//            'image'     => 'required',
//            'sort'      => 'required|integer'
        ]);

        $file_list = $request->file_list;

        foreach($file_list as $file) {
            $im = new Image();
            $im->imageable_type = 'Entities\Goods';
            $im->imageable_id   = $request->goods_id;
            $im->image          = $file['url'];
            $im->sort           = 0;
            $im->save();
        }

        return response()->api();
    }

    public function destory ($id)
    {
        Image::where('id', $id)->delete();
        return response()->api();
    }

    public function updateSort(Request $request)
    {
        $this->apiValidate($request, [
            'id'    => 'required|integer',
        ]);

        $sort = $request->sort ? $request->sort : 0;

        Image::where('id', $request->id)->update(['sort' => $sort]);
        return response()->api();
    }

}
