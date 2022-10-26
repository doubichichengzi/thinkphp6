<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Session;
use think\facade\View;

class index extends AdminBase
{
    public function index()
    {
        // dump(Session("adminUserSession"));
        // exit;
        // echo $this->request->type;
        // dump(session("adminUserSession"));
        // exit;
        return View::fetch();
    }
    public function welcome()
    {

        return View::fetch("welcome");
    }
    public function gets()
    {
        dump(session("adminUserSession"));
    }
    public function gets1()
    {
        echo config("aliyun.host");
    }
}