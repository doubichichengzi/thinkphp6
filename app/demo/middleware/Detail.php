<?php

namespace app\demo\middleware;

class Detail
{
    public function Handle($request, \Closure $next)
    {
        // echo '中间件1';
        // $request->type = '我是中间件detail1';
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
        //echo "detail结束";
    }
}