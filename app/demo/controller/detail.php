<?php

namespace app\demo\controller;

use app\BaseController;
use app\common\model\mysql\User;
use think\exception\HttpException;

class Detail extends BaseController
{
    public function index()
    {
        echo $this->request->type;
        echo "我是detailIndex";
    }
    public function detail($id)
    {
        echo "商品详情{$id}";
        echo $this->request->type;
    }
}