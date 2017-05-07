<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Admin\RichtextRepository as Richtext;
use Entities\Html;

class RichtextController extends Controller
{
    private $modules = [
        'banner' => 'Entities\Banner',
        'goods'  => 'Entities\Goods'
    ];
    public function create(Request $request)
    {
        $richtext = Html::where([
            ['htmlable_type', $this->modules[$request->module]],
            ['htmlable_id', $request->id]
        ])->first();
        return view('admin.richtext')->with('richtext', $richtext)
                                    ->with('module', $request->module)
                                    ->with('id', $request->id);
    }

    public function store(Request $request, Richtext $richtext)
    {
        $html_id = $richtext->store($request->all());
        if ($html_id) {
            $richtext->updateUrl($request->module, $request->htmlable_id, $html_id);
        }
        return response()->api();
    }

}
