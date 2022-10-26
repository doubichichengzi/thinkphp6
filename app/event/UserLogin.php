<?php

declare(strict_types=1);

namespace app\event;

use think\facade\Request;

class UserLogin
{
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
        Request()->user = $user;
        echo 123;
    }
}