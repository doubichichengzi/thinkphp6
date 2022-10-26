<?php

namespace app\api\vaildate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        "username" => "require",
        "phone_number" => "require",
        "code" => ["require", 'number'],
    ];
    protected $message = [
        "username" => "username必须",
        "code.require" => "code必须",
        "code.number" => "code数字",
        "phone_number" => "phone_number必须",
    ];
    protected $scene = [ //场景  字段使用
        "send_code" => ['phone_number'],
        "mall_login" => ['phone_number', 'code'],
    ];
}