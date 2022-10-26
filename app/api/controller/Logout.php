<?php

namespace app\api\controller;

use think\facade\Session;

class Logout extends AuthUser
{
    public function index()
    {
        //删除redis缓存
        $key = config("redis.token_pre") . $this->accessToken;
        $res = cache($key, null);
        if ($res) {
            return show(1, '退出成功');
        } else {
            return show(0, '退出失败');
        }
    }
}