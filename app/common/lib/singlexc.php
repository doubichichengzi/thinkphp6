<?php

namespace app\common\lib;

class Singlexc
{
    private static $instance = null;

    // 禁止被实例化
    private function __construct()
    {
    }

    // 禁止clone
    private function __clone()
    {
    }
    //  实例化自己并保存到$instance中，已实例化则直接调用
    public static function getInstance(): object
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function test($num = 1): string
    {

        return $num++;
    }
}