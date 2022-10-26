<?php

namespace app\demo\controller;

use app\BaseController;
use app\common\model\mysql\User;
use think\exception\HttpException;

class Demo extends BaseController
{
    public function index()
    {
        halt($res);
        exit;
        print_r($this->request->get());
        print_r($this->request->url());
        dump($this->request->param('name', 'cc', 'intval'));
        $res = ["succ" => 1, 'msg' => 2];
        // return json($res);
        // return "123";
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
    public function getUser()
    {
        $res = User::find(["id" => 1]);
        print_r($res);
        echo $res->title;

        print_r($res->toArray());
        exit;
    }
    public function getuser2()
    {
        $user  = new User();
        $res = $user->where([ //->field(["content"])
            ["id", "=", 1],
        ])->find();
        $user2 = clone $user;
        //  print_r($res);
        echo $res->content;

        echo $res->status_text;
        print_r($user2->getLastSql());
    }
    public function getUser3()
    {
        $user = new User();
        $cid = $this->request->param("cid", 0, 'intval');
        if ($cid == '' || $cid <= 0) {
            return show("status.error", '参数错误', []);
        }
        $data = $user->getUserByCid($cid);
        return show(config("status.success"), 'success', $data);
    }
    public function exception1()
    {
        #echo $abc;
        throw new \think\exception\HttpException('403', '找不到该变量');
    }
    public function middle_test()
    {
        echo $this->request->type;
        echo "看中间件";
    }
}