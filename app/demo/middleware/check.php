<?php

namespace app\demo\middleware;

class Check
{
    public function Handle($request, \Closure $next)
    {
        // echo '中间件1';
        $request->type = '我是中间件1';
        return  $next($request);
    }
    /**
     * Undocumented function
     * 中间件结束调度
     * @param \think\Response $response
     * @return void
     */
    public function end(\think\Response $response)
    {
        //echo "中间件check结束";
    }
}