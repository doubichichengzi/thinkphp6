<?php

namespace app\api\controller;

use app\common\model\mysql\MallUser as UserModel;

class User extends AuthUser
{
    public function initialize()
    {
        parent::initialize();
    }
    public function index()
    {
        $key = config("redis.token_pre") . $this->accessToken;
        dump(cache($key));
        print_r($this->userData);
    }
    public function update($id)
    {

        $username = input("username", "", "trim");
        $UserModel = new UserModel();
    }
}