<?php

namespace app\api\exception;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类  处理未知异常
 */
class Http extends Handle
{
    public $httpStatus = 500;
    public function render($request, Throwable $e): Response
    {

        if ($e instanceof \think\Exception) {
            return json(["status" => $e->getCode(), 'msg' => $e->getMessage()], $this->httpStatus);
        }
        if ($e instanceof \think\Exception\HttpResponseException) {

            return parent::render($request, $e);
        }
        if (method_exists($e, 'getStatusCode')) {
            $this->httpStatus = $e->getStatusCode();
        }
        return json(["status" => -1, 'msg' => $e->getMessage()], $this->httpStatus);
    }
}