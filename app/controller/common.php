<?php
/**
 * 通用化api数据格式输出
 *
 * @param integer $status
 * @param string $message
 * @param array $result
 * @param integer $http_code
 * @return void
 */
    function show($status=0,$message='',$result=[],$http_code=200){
        $res=[
            "status"=>$status,
            "message"=>$message,
            "result"=>$result,
        ];
        return json($res,$http_code);
    }
?>