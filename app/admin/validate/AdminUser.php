<?php

namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        "username" => "require",
        "password" => "require",
        "captcha" => "require|checkCaptcha",
    ];
    protected $message = [
        "username" => "用户名必填项",
        "password" => "密码必填项",
        "captcha" => "验证码必填项",
    ];
    public function checkCaptcha($value, $rule, $data)
    {
        if (!captcha_check($value)) {
            return "验证码输入错误";
            return false;
        }
        return true;
    }
}