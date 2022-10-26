<?php

namespace app\api\controller;

use app\BaseController;
use app\common\lib\ClassSms;
use app\common\lib\sms\AliSms;
use app\Request;

class Sms extends BaseController
{
    public function sms()
    {
        //  $phone = Request()->param('phone', '');
        $phone = input('phone_number', '');
        // $code = Request()->param('code', '');
        // dump($phone);
        // pm . visuakizer . set();
        $data = [
            "phone_number" => $phone,
        ];
        try {
            validate(\app\api\vaildate\User::class)->scene("send_code")->check($data);
        } catch (\think\exception\ValidateException $e) {
            return show(config('status.error'), $e->getError());
        }
        $code = rand(100000, 999999);

        /*粗暴解决分流逻辑 */
        $a = rand(0, 99);
        if ($a < 80) {
            // 阿里云逻辑
        } else {
            // 百度云逻辑
        }

        $type = 'ali'; //jd
        /**
         * 调用工厂模式
         * 将调用对象与创建对象分离,调用者直接向工厂请求,减少代码的耦合.提高系统的可维护性与可扩展性。
         * 应用场景：
         * 提供一种类，具有为您创建对象的某些方法，这样就可以使用工厂类创建对象，而不直接使用new。这样如果想更改创建的对象类型，只需更改该工厂即可。
         */
        $smsClassAr = ClassSms::getSmsClass();
        $smsClass = ClassSms::initClass($type, $smsClassAr);
        $phone_number = '13261588026';
        $key = config("redis.code_pre") . $phone_number;
        if (cache($key)) {
            //不允许重复发短信
            return show(config('status.error'), '发送频率太快');
        }
        $res = $smsClass::main($phone_number, $code);

        if ($res) {
            //记录短信验证码到redis，给失效时间 1分钟
            //code_expire
            cache($key, $code, config("redis.code_expire"));

            return show(config('status.success'), '发送成功');
        } else {
            return show(config('status.error'), '发送失败');
        }
    }
    public function gets1()
    {
        dump(Cache()->get("mall_code_pre13261588026"));
    }
}