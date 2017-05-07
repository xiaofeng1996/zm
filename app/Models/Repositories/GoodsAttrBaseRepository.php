<?php

namespace Repositories;

use Entities\Goods;
use Entities\GoodsAttrCategory as Category;
use Entities\GoodsAttr as Attr;

class GoodsAttrBaseRepository
{
    // @param int goods_id
    // @param string attr_names
    // @param string attr_values
    public function getAttrs($data)
    {
        $attr_names = $data['attr_names'] ? explode('@@', $data['attr_names']) : '';
        $attr_values = $data['attr_values'] ? explode('@@', $data['attr_values']) : '';
        $categorys = Category::where('goods_id', $data['goods_id'])->get();
        foreach ($categorys as $key=>$category) {
            $attr_name = $category->attr_name;

            $attr_params_handled = $this->handleAttrParams($attr_names, $attr_values, $attr_name);
            $attr_names_handled = $attr_params_handled ? $attr_params_handled[0] : null;
            $attr_values_handled = $attr_params_handled ? $attr_params_handled[1] : null;

            $values = Attr::where('goods_id', $data['goods_id'])
                            ->groupBy($attr_name)
                            ->select($attr_name . ' as value')
                            ->get();

            $values_allow_select = Attr::where('goods_id', $data['goods_id'])
                                        ->where(function ($query) use ($attr_names_handled, $attr_values_handled) {
                                            if (is_array($attr_names_handled) && count($attr_names_handled)) {
                                                foreach ($attr_names_handled as $k => $v) {
                                                    $query->where($v, $attr_values_handled[$k]);
                                                }
                                            }
                                        })
                                        ->groupBy($attr_name)
                                        ->select($attr_name . ' as value')
                                        ->get();
            // dd($values_allow_select);
            $values_allow_select_array = $this->getAllowSelectArray($values_allow_select);
            foreach ($values as $k => $v) {
                if (in_array($v->value, $values_allow_select_array)) {
                    $values[$k]->allow_select = '1';
                } else {
                    $values[$k]->allow_select = '0';
                }

                $attr_key = getKeyByValue($attr_name, $attr_names);
                if ($attr_key !== null && $v->value == $attr_values[intval($attr_key)]) {
                    $values[$k]->selected = '1';
                } else {
                    $values[$k]->selected = '0';
                }
            }
            $categorys[$key]->values = $values;
        }

        $goods_info = $this->getGoodsInfoByAttr($data['goods_id'], $categorys, $attr_names, $attr_values);
        $goods_info->attrs = $categorys;

        return $goods_info;
    }

    // 处理 attr_names 和 attr_values
    private function handleAttrParams ($attr_names, $attr_values, $value)
    {
        if (!$attr_names) return null;

        $attr_names_flip = array_flip($attr_names);
        if (isset($attr_names_flip[$value])) {
            $key = $attr_names_flip[$value];
            unset($attr_names[$key]);
            unset($attr_values[$key]);
            $attr_names = array_values($attr_names);
            $attr_values = array_values($attr_values);
        }
        return [$attr_names, $attr_values]; 

    }

    private function getAllowSelectArray($values_allow_select)
    {
        $result = [];
        foreach ($values_allow_select as $v) {
            $result[] = $v->value;
        }
        return $result;
    }
    //
    private function getGoodsInfoByAttr($goods_id, $categorys, $attr_names, $attr_values)
    {
        $goods_info = new \stdClass();

        if (count($categorys) == count($attr_names)) {
            $attr = Attr::where('goods_id', $goods_id)
                        ->where(function ($query) use ($attr_names, $attr_values) {
                            if ($attr_names && count($attr_names) > 0) {
                                foreach ($attr_names as $attr_name) {
                                    $attr_key = getKeyByValue($attr_name, $attr_names);
                                    $query->where($attr_name, $attr_values[$attr_key]);
                                }
                            }
                        })
                        ->first();
            $goods_info->id = $goods_id;
            $goods_info->attr_id = $attr->id;
            $goods_info->image = $attr->image;
            $goods_info->price = $attr->price;
            $goods_info->stock = $attr->stock;

            $g = Goods::with('merchant')->find($attr->goods_id);
            $goods_info->fare = $g->merchant->fare;

        } else {
            $goods = Goods::with('merchant')->find($goods_id);
            if (!$goods) throw new \Exception('商品不存在');
            
            $goods_info->id = $goods->id;
            $goods_info->attr_id = 0;
            $goods_info->image = $goods->image;
            $goods_info->price = $goods->price;
            $goods_info->stock = Attr::where('goods_id', $goods_id)->sum('stock');
            $goods_info->fare = $goods->merchant->fare;

        }
        return $goods_info;
    }

}
