<?php

namespace app\admin\business;

use app\admin\validate\AdminUser as AdminUserModel;
use app\BaseController;
use think\facade\Session;
use app\common\model\mysql\MallAdminUser;
use think\facade\Db;

class AdminUser
{
    public function actionLogin($data)
    {

        try {
            $loginchek = new AdminUserModel(); //使用tp6的 vail验证机制
            if (!$loginchek->check($data)) {
                return show(config("status.error"),  $loginchek->getError(), [], 200);
            }

            $username = $data['username'];
            $password = $data['password'];
            $MallAdminUser = new MallAdminUser();

            $user = $MallAdminUser->getUserByUsername($username);
            if ($user == null || $user == '' || empty($user)) {
                return show(config("status.error"), "没有该用户", [], 200);
            }
            if ($user["password"] != md5($password)) {
                return show(config("status.error"), "密码错误", [], 200);
            }

            $updateAr = [
                "last_login_ip" => request()->ip(),
                "last_login_time" => time(),

            ];
            Db::connect("demo")->table("mall_admin_user")->where(["id" => $user['id']])->data($updateAr)->update();
            if (!Session::has("adminUserSession")) {
                Session::set("adminUserSession", $user);
            }
            return show(config("status.success"), '登录成功', [], 200);
        } catch (\Exception $e) {
            //记录日志  $e->getMessage();
            return show(config("status.error"), '登录失败', [], 200);
        }

        /*
        $is_notNull = ["username", "password", "captcha"];
        foreach ($is_notNull as $v) {
            if ($$v == '') {
                return show(config("status.error"), "{$v}为空", [], 200);
            }
        }
        //$captcha_class = new Captcha();
        //  if (!$captcha_class->check($captcha)) {
        if (!captcha_check($captcha)) {
            return show(config("status.error"), "验证码错误", [], 200);
        }

        */
        /*
        $userSessionAdd = [
            "admin{$user['id']}" => $user
        ];

        php在web服务器上运行时使用php-FPM作为和web服务器交流的中间件，在php-FPM中会为每一个请求分配一个work进程，而每个worker进程里都存在一个php解析器，这样就能保证不同访问之间的数据能够进行隔离而不会出现数据混乱的情况。这个是多进程并发php处理的情况。

        而且，session的运行机制是-告诉浏览器我会对请求访问的用户进行标识跟踪，这样浏览器在发送请求的时候就会自动的将所有的cookie值在每次的请求中作为参数发送过去(其实无论服务器上是否开启了session功能都会将该网站的cookie值（未过期的）作为请求的参数发送给服务器)。

         自然在这里面的cookie中, 如果在这次访问中已经开始了session自然也会包括 seesion_id 这个cookie，如果之前服务器没有为这个访问的用户分配相应的session_id 那么在该次请求之后就会分配相应的 seesion_id 告知浏览器（即客户端, 且服务器端设置开启了 session_start），有了session_id 服务器就能够区别不同的访问的用户，从而使用独自的session文件（默认使用文件存储session）。
        
        if (Session::has("adminUserSession")) {
            $aus1 = Session::get('adminUserSession');

            if (!isset($aus1["admin{$user['id']}"])) {
                $aus1 += $userSessionAdd;
            }
        } else {
            Session::set("adminUserSession", $user);
        }
        */

        //event('UserLogin', $user);
        /*
        event(new UserLogin($user));

        print_r(Request()->user);
        exit;
        */
    }
}