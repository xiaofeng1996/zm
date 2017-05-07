<?php

use Illuminate\Support\Collection;

// 转换对象属性为 stdClass 对象
function convertObjToStd ($obj) 
{
    if ($obj == null) {
        return null;
    }

    if ($obj instanceof \stdClass) {
        return $obj;
    }

    if (is_object($obj)) {
        $std = new \stdClass();
        foreach ($obj as $key => $val) {
            $std->$key = $val;
        }
        return $std;
    }
    
    return $obj;

}

// 把 paginate 方法获取的列表去掉总揽信息
function page_helper ($paginate)
{
    if ($paginate) {
        $json = $paginate->toJson();
        $arr = json_decode($json);
        return $arr->data;
    } else {
        return [];
    }
}

// 去除数组中指定值的元素, 目前只支持索引键
function delEleFromArrayByValue($value, $array) 
{
    $array = array_flip($array);
    if (isset($array[$value])) {
        unset($array[$value]);
    }
    $array = array_flip($array);
    return array_values($array);
}

// 获取数组指定元素的 key 值, 只针对不重复数组
function getKeyByValue($value, $array)
{
    if (!is_array($array)) return null;
    $array = array_flip($array);
    if (isset($array[$value])) {
        return $array[$value];
    } else {
        return null;
    }
}

// @param 单位为元
function formatMoney($money)
{
    $money = round($money * 100);
    return sprintf('%.2f', ($money * 1.0 / 100));
}

/** 
 * 组织数据为级联形式
 * @param array or collection $datas 每一项包含 parent_id 字段
 */ 
function formatDataToCascade($datas, $parent_id = 0)
{
    $new_datas = [];
    if ($datas instanceof Collection) {
        $datas = $datas->toArray();
    } else if (!is_array($datas)) {
        throw new \Exception('参数类型不正确');
    }
    $len = count($datas);
    for ($i = 0; $i < $len; $i++) {
        $data = $datas[$i];
        if ($data['parent_id'] == $parent_id) {
            unset($datas[$i]);
            $data['children'] = formatDataToCascade(array_values($datas), $data['id']);
            $new_datas[] = $data;
        }
    }
    return $new_datas;
}