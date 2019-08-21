<?php
namespace utils\src;

/**
 * Class Operator
 * @package utils\src
 */
final class Operator
{

    /**
     * 移动
     * @var array
     */
    private static $mobile = ['134', '135', '136', '137', '138', '139', '147', '150', '151', '152', '157', '158', '159', '178', '182', '183', '184', '187', '188'];

    /**
     * 联通
     * @var array
     */
    private static $unicom = ['130','131','132','155', '156', '185', '186', '145', '176','166'];

    /**
     * 电信
     * @var array
     */
    private static $telecom = ['133', '153', '180', '181', '189', '177'];

    /**
     *
     * @param $phone
     * @param $operator | default mobile
     * @return int
     */
    public static function is($phone,$operator = 1)
    {
        switch ($operator) {
            case 1:
                return in_array(substr($phone, 0, 3), self::$mobile);
            case 2:
                return in_array(substr($phone, 0, 3), self::$unicom);
            case 3:
                return in_array(substr($phone, 0, 3), self::$telecom);
            default:
                return false;
        }
    }


}