<?php

namespace App\Libraries\Utils;


/**
 * 数组和对象 操作工具集合
 *
 * Class Mid
 * @package App\Libraries\Utils
 */
class Arrays
{
    /**
     * 将下划线转换成驼峰式
     *
     * @param mixed<string|array> $data
     * @param boolean $ucfirst
     * @return mixed<string|array>
     */
    public static function convertUnderline($data , $ucfirst = false)
    {
        if (!is_string($data)) {
            $return = array();
            foreach ($data as $key => $str) {
                $key          = preg_replace_callback('/(([-_]+)([A-Za-z]{1}))/i', function ($matches) {
                    if ($matches[2] === '_') {
                        return strtoupper($matches[3]);
                    }
                    return $matches[0];
                }, $key);
                $key          = $ucfirst ? ucfirst($key) : $key;
                $return[$key] = $str;
            }
            return $return;
        } else {
            $data = preg_replace_callback('/(([-_]+)([A-Za-z]{1}))/i', function ($matches) {
                if ($matches[2] === '_') {
                    return strtoupper($matches[3]);
                }
                return $matches[0];
            }, $data);
            return $ucfirst ? ucfirst($data) : $data;
        }
    }

    /**
     * 将数组或对象中的指定下标中的内容，提炼成一维数组
     *
     * @param object|array $array
     * @param string $field
     * @return array
     */
    public static function toFlat($array, $field = null)
    {
        $field = $field ?: 'id';
        $rs = array();
        foreach ($array as $t) {
            $rs[] = is_array($t) ? $t[$field] : $t->$field;
        }
        return $rs;
    }

    /**
     * 将数组或对象中的指定字段设为为key和value，提炼成一维数组
     *
     * @param object|array $iterator
     * @param string $fieldKey 数组下标
     * @param string $fieldVal 数组下标的值
     * @param boolean $isArray
     * @return array
     */
    public static function toKV(&$iterator, $fieldKey = null, $fieldVal = null, $isArray = false)
    {
        $rs = array();
        foreach ($iterator as $t) {
            $k = is_array($t) ? $t[$fieldKey] : $t->$fieldKey;
            $v = is_array($t) ? $t[$fieldVal] : $t->$fieldVal;
            if ($isArray) {
                if (array_key_exists($k, $rs)) {
                    $rs[$k][] = $v;
                } else {
                    $rs[$k] = array($v);
                }
            } else {
                $rs[$k] = $v;
            }
        }
        return $rs;
    }

    /**
     * 使用原有数组中的值做为新数组的key，创建一个新数组返回
     *
     * @param object|array $iterator
     * @param string $fieldKey 数组下标
     * @param boolean $isArray
     * @return array
     */
    public static function toArrayByNewKey(&$iterator, $fieldKey = null, $isArray = false)
    {
        $rs = array();
        foreach ($iterator as $t) {
            $k = is_array($t) ? $t[$fieldKey] : $t->$fieldKey;
            if ($isArray) {
                if (array_key_exists($k, $rs)) {
                    $rs[$k][] = $t;
                } else {
                    $rs[$k] = array($t);
                }
            } else {
                $rs[$k] = $t;
            }
        }
        return $rs;
    }


    /**
     * 根据数组下标优先级选值 (值为空剔除)
     * 例如: ['','张三','李四'] => '张三'
     *
     * @param $array
     * @return string
     */
    public static function toArrayByIndex($array)
    {
        $return = null;
        foreach ($array as $v) {
            if ($v) {
                $return = $v;
                break;
            }
        }
        return $return;
    }

    /**
     * 二维转数组
     *
     * @param $array
     * @return array
     */
    public static function toOnly($array)
    {
        $list = [];
        for ($i = 0; $i < count($array); $i++) {
            foreach ($array[$i] as $k => $v) {
                $list[$i] = $v;
            }
        }
        return $list;
    }

    /**
     * 对象转换成数组
     *
     * @param object $obj
     * @return array
     */
    public static function objectToArray($obj)
    {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val)) || is_object($val) ? object_to_array($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }


    /**
     * 将数组中的空值元素剔除返回新的数组
     *
     * @param $metaArray
     * @param $isFiltrationZero | 是否过滤0 默认过滤
     * @return array
     */
    public static function regroupArray($metaArray,$isFiltrationZero = true)
    {
        $result = [];
        foreach ($metaArray as $field => $val){
            if($isFiltrationZero){
                if(!empty(trim($val))){
                    $result[$field] = $val;
                }
            }else{
                if(!empty(trim($val)) || $val !== ''){
                    $result[$field] = $val;
                }
            }
        }
        return $result;
    }


    /**
     * 数组去除重复值
     *
     * @param $metaArray | 原数组
     * @param $field | 去重复字段
     * @return array
     */
    public static function remDuplicateArray($metaArray,$field)
    {
        $result = [];
        foreach ($metaArray as $key => $val) {
            if(!isset($result[$val[$field]])){
                $result[$val[$field]] = $val;
            }else{
                unset($val[$field]);
            }
        }
        $result = array_values($result);
        return $result;
    }


    /**
     * @param $metaArray    | 原数组
     * @param $field        | 需要变更的字段
     * @param $name         | 变更的字段名
     * @return array
     */
    public static function changeFieldArray($metaArray,$field,$name)
    {
        $i = 0;
        $result = [];
        foreach ($metaArray as $key => $val){
            $result[$i] = $val;
            $result[$i]["$name"] = $val[$field];
            unset($result[$i][$field]);
            $i++;
        }
        return $result;
    }


    /**
     * 剔除数组元素
     *
     * @param $metaArray
     * @param $field
     * @return array
     */
    public static function toUnset($metaArray,$field)
    {
        $result = [];
        foreach ($metaArray as $val){
            unset($val[$field]);
            $result = $val;
        }
        return $result;
    }


    /**
     * 数组值转换成int
     *
     * @param $metaArray
     * @return array
     */
    public static function toArrayValuesTransitionInt($metaArray)
    {
        $result = [];
        foreach ($metaArray as $key => $val){
            $result[$key] = intval($val);
        }
        return $result;
    }


    /**
     * array sequence
     *
     * @param $array
     * @param $field
     * @param string $sort
     * @return mixed
     */
    public static  function arraySequence($array, $field, $sort = 'SORT_DESC')
	{
		$arrSort = array();
		foreach ($array as $uniqid => $row) {
			foreach ($row as $key => $value) {
				$arrSort[$key][$uniqid] = $value;
			}
		}
		array_multisort($arrSort[$field], constant($sort), $array);
		return $array;
	}

}
