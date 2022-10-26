<?php

use app\ExceptionHandle;
use app\Request;
#use app\demo\exception\Http;
// 容器Provider定义文件
return [
    'think\exception\Handle' => 'app\\api\\exception\\Http',
    # 'think\exception\Handle' => Http::class,

];