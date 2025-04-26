<?php
// index.php

function handler($event, $context) {
    // 获取 POST 请求的原始数据
    $requestData = file_get_contents('php://input');
    
    // 如果收到请求数据，继续处理
    if (!empty($requestData)) {
        // 这里可以进行文件上传或视频链接处理
        // 比如调用 upload.php 来处理
        require_once 'upload.php';

        // 返回处理结果
        return "请求已处理: " . $requestData;
    } else {
        // 如果没有收到数据，返回提示信息
        return "没有收到有效数据，请上传视频或输入链接。";
    }
}
?>
