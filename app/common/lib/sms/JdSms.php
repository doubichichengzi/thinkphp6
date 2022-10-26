<?php

declare(strict_types=1);

namespace app\common\lib\sms;

class JdSms implements SmsBase
{
    public static function main($phoneNumber, $code)
    {
        return show(config("status.success"), '发送成功');
    }
}