<?php

namespace app\admin\controller;

use app\BaseController;
use think\exception\HttpResponseException;
use think\response\Redirect;

class AdminBase extends BaseController
{
    public $adminuser;
    //adminUserSession
    public function initialize()
    {
        parent::initialize();
        //判断是否登录
        /*
        if (!$this->isLogin()) {
            return $this->redirect('/admin/login/index');
        }
        */
    }
    /**
     * 判断是否登录
     *
     * @return boolean
     */
    public function isLogin()
    {
        $this->adminuser = session("adminUserSession");
        if (empty($this->adminuser)) {
            return false;
        }
        return true;
    }
    public function redirect(...$args)
    {
        /*
        可以通过...将函数参数存储在紧接的可遍历的变量中。
        */
        throw new HttpResponseException(Redirect(...$args));
    }
}