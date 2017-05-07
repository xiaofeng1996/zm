<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Admin\Banner\BannerRepository as Banner;

class BannerController extends Controller
{
    public function create(Request $request, Banner $banner)
    {
        $this->apiValidate($request, [
            'keytype' => 'required|integer',
            'keyid' => 'required|integer',
            'sort' => 'required|integer',
            'link' => 'required_if:keytype,2',
        ]);
        $banner->create($request->input());
        return response()->api();
    }

    public function update(Request $request, Banner $banner)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer|min:1',
            'keytype' => 'required|integer',
            'keyid' => 'required|integer|min:1',
            'sort' => 'required|integer',
            'link' => 'required_if:keytype,2',
        ]);
        $banner->update($request->input());
        return response()->api();
    }

    public function delete(Request $request, Banner $banner)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer|min:1'
        ]);
        $banner->delete($request->input('id'));
        return response()->api();
    }
}
