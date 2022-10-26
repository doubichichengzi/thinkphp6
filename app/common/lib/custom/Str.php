<?php

declare(strict_types=1);

namespace app\common\lib\custom;

class Str
{
    public static function getLoginToken(string $string)
    { //生成用户token
        $salt = 'tp6shop';
        $str = md5(uniqid(md5(microtime(), true)));

        $token = sha1($str . $string . $salt);
        return $token;
    }
}