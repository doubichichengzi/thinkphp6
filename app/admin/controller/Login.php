<?php

namespace app\admin\controller;

#use app\admin\validate\AdminUser;
use app\BaseController;
use think\captcha\facade\Captcha;
use think\facade\View;
use app\common\model\mysql\MallAdminUser;
use think\facade\Db;
use think\facade\Session;
use think\facade\Request;
use app\event\UserLogin;
use app\admin\business\AdminUser;

class Login extends AdminBase
{
    //7548bdd4f57d993f62615eff5af4389976a6b534
    public function initialize()
    {
        // if ($this->isLogin()) {
        //     return $this->redirect("/admin/index/index");
        // }
    }
    public function index()
    {
        return View::fetch();
    }
    public function gets()
    {
        dump(session("adminUserSession"));
    }
    public function check()
    {
        // print_r($_GET);
        if (!$this->request->isPost()) {
            return show(config("status.error"), '请求方式错误', [], 200);
        }
        $username = $this->request->param("username", '', 'trim');
        $password = $this->request->param("password", '', 'trim');
        $captcha = $this->request->param("captcha", '', 'trim');

        $data = [
            "username" => $username,
            "password" => $password,
            "captcha" => $captcha,
        ];
        $AdminUser_business = new AdminUser();
        $res = $AdminUser_business->actionLogin($data); //业务层处理
        return $res;
    }
}