<?php
namespace app\controller;

use app\Request;
use think\facade\Request as re2;
class Learn{
    public function index(Request $request){
    
        dump($request->param("a",2,'intval'));
        //dump($this->request->param('a','2','intval')); 与第一不能混用
        dump(input('a'));
        dump(request()->get("a"));
        dump(re2::param("b"));

        $request->isGet();
        $request->isPost();
        $request->isAjax();
    }
}
?>