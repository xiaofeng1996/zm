<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Common\FileRepository as File;

class FileController extends Controller
{
    public function index(Request $request, File $file)
    {
        $path = $file->store($request);
        return response()->api(['path' => 'storage/' . $path]);
    }
}
