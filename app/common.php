<?php
// 应用公共文件
function show($status = 0, $message = '', $result = [], $http_code = 200)
{

    $res = [
        "status" => $status,
        "message" => $message,
        "result" => $result,
    ];
    return json($res, $http_code);
}