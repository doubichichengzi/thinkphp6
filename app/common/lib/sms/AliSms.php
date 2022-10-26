<?php

declare(strict_types=1);

namespace app\common\lib\sms;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
//use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use think\facade\Log;

class AliSms implements SmsBase
{

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Dysmsapi Client
     */
    public static function createClient($accessKeyId, $accessKeySecret)
    {
        $config = new Config([
            // 您的 AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 您的 AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        $config->endpoint = config("aliyun.host");
        return new Dysmsapi($config);
    }

    /**
     * @param string[] $args
     * @return void
     */
    //   public static function main($args)
    public static function main($phoneNumber, $code)
    {
        /*
        $temlateParam = [
            "code" => $code
        ];
        */
        $accessKeyId = "LTAI5tF7XgDa9ECKpMPxcpe3";
        $accessKeySecret = "qu552m0CtBM0NWI9LMoMdUso3lGF1B";
        // $client = self::createClient("accessKeyId", "accessKeySecret");

        $client = self::createClient($accessKeyId, $accessKeySecret);
        $temlateParam = [
            "code" => $code
        ];
        $sendSmsRequest = new SendSmsRequest([
            "signName" => "阿里云短信测试",
            "templateCode" => "SMS_154950909",
            "phoneNumbers" => "13261588026",
            //"templateParam" => "{\"code\":\"1234\"}"
            "templateParam" => json_encode($temlateParam)
        ]);
        // var_dump($sendSmsRequest);
        $runtime = new RuntimeOptions([]);
        $res = [];

        try {
            // 复制代码运行请自行打印 API 的返回值
            $res = $client->sendSmsWithOptions($sendSmsRequest, $runtime);
            Log::info("alisms-sendcode-result($phoneNumber)" . json_encode($res));

            /*
            '触发天级流控Permits:10
            短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，支持1条/分钟，5条/小时 ，累计10条/天
            */
            // print_r($res);
            if (isset($res->body) && $res->body->code != 'OK') {
                return false;
            }
        } catch (Exception $error) {

            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            Log::info("alisms-sendcode-error({$error->getMessage()})");
            return false;

            print($error->getMessage());
        }


        if (isset($res->body) && $res->body->code != 'OK') {
            return false;
        }
        return true;
    }
    public static function sendCode($phone, $code)
    {
        if (empty($phone) || empty($code)) {
            return false;
        }
        $temlateParam = [
            "code" => $code
        ];

        $accessKeyId = "LTAI5tF7XgDa9ECKpMPxcpe3";
        $accessKeySecret = "qu552m0CtBM0NWI9LMoMdUso3lGF1B";

        // $client = self::createClient("accessKeyId", "accessKeySecret");
        $client = self::createClient($accessKeyId, $accessKeySecret);
        $sendSmsRequest = new SendSmsRequest([
            "signName" => "阿里云短信测试",
            "templateCode" => "SMS_154950909",
            "phoneNumbers" => $phone,
            "templateParam" => json_encode($temlateParam)
        ]);
        $runtime = new RuntimeOptions([]);

        try {
            // 复制代码运行请自行打印 API 的返回值
            $client->sendSmsWithOptions($sendSmsRequest, $runtime);
            dump($client);
            exit;
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
//AliSms::sendCode(array_slice($argv, 1));