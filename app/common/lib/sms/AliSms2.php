<?php

declare(strict_types=1);

namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Dysmsapi\Dysmsapi;

class AliSms2
{
    public static function sendCode(string $phone, int $code): bool
    {
        if (empty($phone) || empty($code)) {
            return  false;
        }
        AlibabaCloud::accessKeyClient('<your-access-key-id>', '<your-access-key-secret>')
            // use STS Token
            // AlibabaCloud::stsClient('<your-access-key-id>', '<your-access-key-secret>', '<your-sts-token>')   
            ->regionId('cn-hangzhou')
            ->asDefaultClient()->options([]);

        try {
            $request = Dysmsapi::v20170525()->sendSms();
            $result = $request
                ->withSignName("阿里云短信测试")
                ->withTemplateCode("SMS_154950909")
                ->withPhoneNumbers("13261588026")
                ->withTemplateParam("{\"code\":\"1234\"}")
                ->debug(true) // Enable the debug will output detailed information

                ->request();
            print_r($result->toArray());
        } catch (ClientException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        } catch (ServerException $exception) {
            echo $exception->getMessage() . PHP_EOL;
            echo $exception->getErrorCode() . PHP_EOL;
            echo $exception->getRequestId() . PHP_EOL;
            echo $exception->getErrorMessage() . PHP_EOL;
        }
    }
}