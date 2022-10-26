<?php

namespace app\api\controller;

use app\BaseController;
use think\facade\Cache;
use think\view\driver\Think;

class AuthUser extends ApiBase
{
    /**
     * 需要登录的apicontroller
     *
     * @return void
     */
    public $accessToken = "";
    public $userData = [];
    public function initialize()
    {
        parent::initialize();
        $this->accessToken =  $this->request->header("Access-Token");

        if (!$this->accessToken || !$this->checkLogin()) {

            return $this->show(0, '没有登陆');
        }
    }

    public function checkLogin()
    {



        //echo $this->accessToken;
        //  print_r($this->request->header());

        // dump(Cache::get($this->accessToken));
        //dump(cache($this->accessToken));
        // $this->userData = cache('mall_token_pre7548bdd4f57d993f62615eff5af4389976a6b534');
        // dump($this->userData);
        $this->userData = cache(config("redis.token_pre") . $this->accessToken);
        // dump($this->userData);

        if (empty($this->userData['id']) || empty($this->userData['username'])) {

            return false;
            // throw new \think\Exception("没有登陆", 0);
        }
        return true;
        // exit;
    }
}