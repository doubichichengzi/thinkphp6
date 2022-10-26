<?php

namespace app\controller;

class Error
{
   public function __call($name, $arguments)
   {

      // return show(-1,'控制器不存在',[],'404');
      return json(["status" => config("status.controller_notfound"), 'msg' => "控制器2不存在"]);
   }
}