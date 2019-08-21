<?php
namespace utils\src;

/**
 * Class Time
 * @package utils\src
 */
final class Time
{

    /**
     * @var array
     */
    private $differPattern = ['year','month','day','hour','minute'];


    /**
     * differ function
     *
     * @param $begin
     * @param $end
     * @param string $pattern
     * @return int
     */
    public static function differ($begin,$end,$pattern = "day")
    {
        if(!in_array($pattern,['year','month','day','hour','minute'])) {
            return 0;
        }
        $diff = $end-$begin;
        switch ($pattern){
            case 'year':
                return 0;
                break;
            case 'month':
                $diff = intval($diff/(86400*30));//月
                break;
            case 'day':
                $diff = intval($diff/86400);//天
                break;
            case 'hour':
                $diff = intval($diff/3600);//小时
                break;
            case 'minute':
                $diff = intval($diff/60);//分钟
                break;
            default;
        }
        return $diff;
    }



}