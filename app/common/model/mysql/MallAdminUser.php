<?php

namespace app\common\model\mysql;

use think\Model;
use think\facade\Db;

class MallAdminUser extends Model
{

    public function __construct()
    {
        parent::__construct();

        //其他代码
    }
    protected $connection = 'demo';
    public function getUserByUsername($username)
    {
        if ($username == '') {
            return [];
        }
        $data  = Db::connect("demo")->table("mall_admin_user")->where([
            ['username', '=', $username]
        ])->find(); //->toArray(); //->fetchSql(); //

        return $data;
    }
}