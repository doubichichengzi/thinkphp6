<?php

namespace app\api\controller;

use app\api\controller\ApiBase;
use app\api\vaildate\User as UserVaildate;
use app\common\model\mysql\MallUser;
use think\facade\Log;
use app\common\lib\custom\Str;

class Login extends ApiBase
{
    public function initialize()
    {
        // if ($this->isLogin()) {
        //     return $this->redirect("/admin/index/index");
        // }
    }
    public function index()
    {
        /*
        if (!$this->request->isPost()) {
            return show(config("status.error"), '请求方式错误', [], 200);
        }
        */

        /*
        
         7548bdd4f57d993f62615eff5af4389976a6b534
    d03922734392f2f174b87325f86af86ff96fb44a
        */
        // dump(cache("mall_token_pre7548bdd4f57d993f62615eff5af4389976a6b534"));
        // print_r($_SERVER);
        // exit;
        $phone_number = input("phone_number", '', 'string');
        $code = input("code", '');


        $data = [
            "phone_number" => $phone_number,
            "code" => $code,
        ];
        //  print_r($data);
        $UserVaildate = new UserVaildate();
        if (!$UserVaildate->scene("mall_login")->check($data)) {
            throw new \think\Exception($UserVaildate->getError(), -666); //通过抛出异常来返回数据
            //return show(config("status.error"), $UserVaildate->getError());
        }
        $key = config("redis.code_pre") . $phone_number;
        /*
        if (empty(cache($key)) || cache($key) != $code) {
            return show(config("status.error"), '验证码错误');
        }
        */
        $MallUser = new MallUser();

        $user = $MallUser->getUserByPhonenumber($phone_number);

        if (empty($user)) {
            //  return show(config("status.error"), '用户不存在');
            $username = 'shop' . $phone_number;
            $addData = [
                "username" => $username,
                "password" => "0",
                "phone_number" => $phone_number
            ];
            try {
                $MallUser->save($addData);
                $user_id = $MallUser->id;
            } catch (\Exception $e) {
                Log::info("login-maill_user_save($phone_number)({$e->getMessage()})");
                throw new \think\Exception("数据库异常", -666); //通过抛出异常来返回数据
            }

            // echo $user_id;
        } else {
            //更新表 最后登录时间 最后登录ip等
            $user_id = $user["id"];
            $username = $user["username"];
            //   print_r($user);
        }
        $token = Str::getLoginToken($phone_number);

        $userNew = [
            "id" => $user_id,
            "username" => $username,
        ];
        cache(config("redis.token_pre") . $token, $userNew, 3600 * 24 * 3);

        return show(1, '登陆成功', $userNew + ["token" => $token], 200);
    }
    public function gets()
    {
        dump(session("adminUserSession"));
    }
}