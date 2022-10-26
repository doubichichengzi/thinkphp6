<?php

declare(strict_types=1);

namespace app\common\lib;

class ClassSms
{
    /**
     * 调用工厂模式
     * 将调用对象与创建对象分离,调用者直接向工厂请求,减少代码的耦合.提高系统的可维护性与可扩展性。
     * 应用场景：
     * 提供一种类，具有为您创建对象的某些方法，这样就可以使用工厂类创建对象，而不直接使用new。这样如果想更改创建的对象类型，只需更改该工厂即可。
     */
    public static function getSmsClass()
    {
        return [
            "ali" => "app\common\lib\sms\Alisms",
            "jd" => "app\common\lib\sms\Jdsms",
        ];
    }
    public function uploadClass()
    {
    }
    public static  function initClass(string $type, array  $class, $params = [], $needInstance = false)
    {
        //如果工厂模式掉用的方法是静态的  返回类库 如 Alisms
        //如果不是静态的 需要返回对象
        if (!array_key_exists($type, $class)) {
            return false;
        }

        //needInstance  是否静态

        $className = $class[$type];

        /**
         * PHP ReflectionClass::newInstanceArgs 反射函数
         * ReflectionClass::newInstanceArgs - 从给出的参数创建一个新的类实例。

         * ReflectionClass::newInstanceArgs() 创建一个类的新实例，给出的参数将传递到类的构造函数。
         *(new \ReflectionClass($className)) 建立 $className 的反射类
         *->newInstanceArgs($params) 实例化  $className 参数将传递到类的构造函数
         */
        return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}