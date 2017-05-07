<?php

namespace Repositories\Admin;

use DB;
use Entities\Html;
use Entities\Banner;
use Entities\Goods;
use App\Exceptions\ApiException;

class RichtextRepository 
{
    private $types = [
        'banner' => 'Entities\Banner',
        'goods'  => 'Entities\Goods'
    ];

    public function store($data)
    {
         try {
            $htmlable_type = isset($this->types[$data['module']]) 
                            ? $this->types[$data['module']]
                            : '';
            if (isset($data['id']) && $data['id']) {
                $this->storeRichtext($data['id'], $htmlable_type, $data['htmlable_id'], $data['content']);
                return $data['id'];
            } else {
                $html_id = $this->createRichtext($htmlable_type, $data['htmlable_id'], $data['content']);
                return $html_id;
            }
         } catch (\Exception $e) {
             throw new ApiException('保存失败');
         }
    }

    public function updateUrl($module, $htmlable_id, $html_id)
    {
        switch ($module) {
            case 'banner':
                Banner::where('id', $htmlable_id)->update([
                    'link' => 'richtext/' . $html_id
                ]);
                break;
            case 'goods':
                Goods::where('id', $htmlable_id)->update([
                    'rich_content_link' => 'richtext/' . $html_id
                ]);
                break;
            default:
                throw new ApiException('保存模块类型不正确');
                break;

        }
    }

    private function storeRichtext($id, $htmlable_type, $htmlable_id, $content)
    {
        $html = Html::find($id);
        $html->htmlable_type    = $htmlable_type;
        $html->htmlable_id      = $htmlable_id;
        $html->content          = $content;
        $html->save();
    }

    private function createRichtext($htmlable_type, $htmlable_id, $content)
    {
        $html = new Html();

        $html->htmlable_type    = $htmlable_type;
        $html->htmlable_id      = $htmlable_id;
        $html->content          = $content;
        $html->save();

        return $html->id;
    }
}

