<?php

namespace App\Http\Controllers\Web\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Html;

class RichtextController extends Controller
{
    public function show($id = 0)
    {
        $html = Html::find($id);
        return view('web.richtext')->with('content', $html ? $html->content : '');
    }
}
