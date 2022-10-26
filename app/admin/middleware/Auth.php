<?php
//declare(strict_types=1); strict_types=1 针对参数类型开启严格模式，进行数据类型检验，默认是弱类型校验
//哪个文件写了declare,哪个文件中的所有代码就需要检查
namespace app\admin\middleware;

class Auth
{
    public function Handle($request, \Closure $next)
    {
        // echo '中间件1';

        $request->type = '我是中间件1';
        //前置中间件 写在闭包前

        $adminuser = session("adminUserSession");
        $needLoginAr = [
            "Index",
        ];
        //  $url = $_SERVER["REQUEST_URI"];
        $url = $request->pathinfo();



        //  print_r(parse_url($url));


        // if (empty($adminuser) && in_array($request->controller(), $needLoginAr)) {
        if (empty($adminuser) && !preg_match('/login/', $url)) {
            return redirect('/admin/login/index');
        }

        //if (!empty($adminuser) && $request->controller() == 'Login' && $request->action() == 'index') {
        if (!empty($adminuser) && preg_match('/login/', $url)) {
            return redirect('/admin/index/index');
        }

        $response =  $next($request);

        //后置中间件 卸载闭包后

        // echo $request->controller();
        // print_r($request);
        // exit;




        return $response;
    }
    /**
     * Undocumented function
     * 中间件结束调度
     * @param \think\Response $response
     * @return void
     */
    public function end(\think\Response $response)
    {
    }
}