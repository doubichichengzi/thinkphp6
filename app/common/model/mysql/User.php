<?php

namespace app\common\model\mysql;

use app\BaseController;
use think\Model;
use think\facade\Db;

class User extends Model
{

    public $sname =  ["1" => "正常", '2' => "失效"];
    public function getStatusTextAttr($val, $data)
    {
        $name = ["1" => "正常", '2' => "失效"];
        return $name[$data['status']];
    }
    public function getUserByCid($cid = -1)
    {
        if ($cid <= 0) {
            return [];
        }
        $users  = Db::table("qxc.user")
            ->where(["c_id" => $cid])->select()
            ->toArray();

        if (empty($users)) {
            return [];
        }
        foreach ($users as $k => $v) {
            $users[$k] += ["status_name" => $this->sname[$v["status"]]];
        }
        return $users;
    }
}