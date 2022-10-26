<?php

namespace app\api\controller;

use app\BaseController;
use think\exception\HttpResponseException;

class ApiBase extends BaseController
{
    /**
     * 不需要登录的基础api
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    public function show(...$args)
    {

        throw new HttpResponseException(show(...$args));
    }
}