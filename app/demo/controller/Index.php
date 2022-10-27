<?php

namespace app\demo\controller;

use app\BaseController;
use think\cache\driver\Redis;
use think\facade\Db;
use think\facade\Cache;
use think\facade\Session;
use app\common\lib\Singlexc;

class Index extends BaseController
{
    public function index()
    {
        
        $data=["succ"=>1,'status'=>1,'msg'=>1,'data'=>["username"=>'qxc']];
        return json($data);
        echo  "我在8082222";

        print_r(Session::get("adminUserSession"));

        exit;
        $data = Db::table("demo.mall_category")->order(
            ['listorder', 'id' => 'asc']
        )->field("*,id as cat_id")->select()->toArray();



        // print_r($re1);
        // exit;
        $tree = $this->tree($data);
        $qiege_tree = $this->sliceTreeArr($tree);
        print_r($qiege_tree);
    }
    public function getdl()
    {
        $Singlexc = Singlexc::getInstance();
        $Singlexc2 = Singlexc::getInstance();
        echo $Singlexc->test();
        echo $Singlexc2->test();
    }
    public function setsession1()
    {
        $user = [
            "sessionid" => Session::getId(),
            "name" => "qxc"
        ];
        if (!Session::has("adminUserSession")) {
            Session::set("adminUserSession", $user);
        }
    }
    public function tree($data)
    {
        $re1 = [];
        foreach ($data as $k => $v) {
            $re1[$v['cat_id']] = $v;
        }
        $tree = [];
        foreach ($re1 as $k => $v) {

            if (isset($re1[$v["pid"]])) {
                $re1[$v["pid"]]["list"][] = &$re1[$k];
            } else {
                $tree[] = &$re1[$k];
            }
        }
        return $tree;
    }
    //对无限极分类进行 切割 
    public function sliceTreeArr($data, $firstCount = 5, $seconedCount = 3, $thirdCount = 5)
    {
        //一级分类
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if (!empty($v["list"])) {
                $data[$k]['list'] = array_slice($v["list"], 0, $seconedCount);
                foreach ($v["list"] as $ke => $ve) {
                    if (!empty($ve["list"])) {
                        $data[$k]['list'][$ke]['list'] = array_slice($ve["list"], 0, $thirdCount);
                    }
                }
            }
        }
        return $data;
    }
    public function setCart()
    {

        $data = input("param.");
        print_r($data);

        $user_id = 1;
        $createTime = time();

        $hsetdata = [
            "skuid" => $data["skuid"],
            "num" => $data["num"],
            "createTime" => $createTime,
        ];
        // $reids = new Redis();
        // $reids->connect("127.0.0.1");
        // $reids->set("user", 'qxc');
        //Cache::Strore('reids')->hSet("mall_cart_{$user_id}", $data["skuid"], json_encode($hsetdata));
        // cache("eww", 'qxc', 300);


        //  Cache::store('redis')->set("username", 'qqq', 60);
        //  Cache::store('redis')->hSet("mall_cart_{$user_id}", $data["skuid"], json_encode($hsetdata));

        $res = Cache::hGetAll("mall_cart_{$user_id}");
        //  print_r($res);
        $cart = [];
        print_r($res);

        foreach ($res as $k => $v) {
            $v1 = json_decode("{$v}", true);
            $cart[$k] = $v1 + ['date' => date("Y-m-d H:i:s", $v1["createTime"])];
        }
        arsort($cart);
        print_r($cart);
        array_multisort(array_column($cart, 'createTime'), SORT_DESC, $cart);
        print_r($cart);
    }
    public function test1()
    {
        $id = $_GET["id"];
        // Cache::zAdd("order_status", time(), $id);
        /*
        for ($i = 1; $i <= 100; $i++) {
            Cache::zAdd("order_status", time(), $i);
            sleep(1);
        }
        */
        // $res = Cache::zRangeByScore("order_status", 0, time(), ["limit" => [0, 1]]);
        $res = Cache::zRangeByScore("order_status", 0, time());
        //     Cache::zRem("order_status", $res[0]);
        print_r($res);
    }
}