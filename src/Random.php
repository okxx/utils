<?php
namespace utils\src;

/**
 * Class Random
 * @package App\Libraries\Utils
 */
final class Random
{

    /**
     * @param int $length
     * @param int $type
     * @return string
     */
    public static function randVar($length = 0, $type = 0)
    {
        $range = array(0    =>  '0123456789',
                       1    =>  'abcdefghijklmnopqrstuvwxyz',
                       2    =>  'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                       3    =>  '0123456789abcdefghijklmnopqrstuvwxyz',
                       4    =>  '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                       5    =>  'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                       6    =>  '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                       7    =>  '3456789abcdefghijkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXY',
                       8    =>  '23456789ABCDEFGHJKLMNPQRSTUVWXY',
                       9    =>  '6345829ABDEGHCJKLMNPQRSFTUWXY',
                       10   =>  '23456789');
        if (false === array_key_exists($type, $range)) {
            $type = 6;
        }
        $character = '';
        $maxLength = strlen($range[$type])-1;
        for ($i = 0; $i < $length; ++$i) {
            $character .= $range[$type][mt_rand(0, $maxLength)];
        }
        return $character;
    }

    /**
     * rand email activation code
     *
     * @param string $t
     * @return string
     */
    public static function emailActivationCode($t = '')
    {
        return md5(round(microtime(true) * 1000) . $t . self::randVar(6, 6));
    }

}
