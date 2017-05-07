<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use App\Exceptions\ApiException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiValidate($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            throw new ApiException($validator->errors()->first());
        }
    }

    public function storeFile($request, $file_name = 'file')
    {
        $path = $request->$file_name->store('images/' . date('Y') . '/' . date('m'), 'public');
        return '/storage/' . $path;
    }


}
