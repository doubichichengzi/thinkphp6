<?php

namespace app\common\model\mysql;

use think\Model;
use think\facade\Db;

class MallUser extends Model
{
    protected $table = 'mall_user';
    protected $connection = 'demo';
    public function getUserByPhonenumber($phone_number)
    {
        $user = $this->where([
            ["phone_number", '=', $phone_number]
        ])->find();
        if ($user == null || empty($user)) {
            return [];
        } else {
            return $user->toArray();
        }
        return $user;
    }
    public function getUserByid($id)
    {
        $user = $this->where([
            ["id", '=', $id]
        ])->find();
        if ($user == null || empty($user)) {
            return [];
        } else {
            return $user->toArray();
        }
        return $user;
    }
}