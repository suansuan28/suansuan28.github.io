<?php
// upload.php

// 检查是否通过 POST 请求发送数据
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

// 如果是 POST 请求
if ($requestMethod === 'POST') {
    // 处理上传的视频文件
    if (!empty($_FILES['videoFile']['name'])) {
        $targetDir = "uploads/";  // 文件上传目录
        $targetFile = $targetDir . basename($_FILES["videoFile"]["name"]);
        
        // 尝试移动上传的文件到指定目录
        if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $targetFile)) {
            echo "文件上传成功: " . $targetFile;
            
            // 调用 Coze API 进行视频处理
            $videoPath = $targetFile;  // 获取上传视频的路径
            callCozeAPI($videoPath);
        } else {
            echo "文件上传失败";
        }
    } 
    // 处理视频链接
    elseif (!empty($_POST['videoLink'])) {
        $videoLink = $_POST['videoLink'];
        
        // 调用 Coze API 进行视频链接处理
        callCozeAPI($videoLink);
    }
} else {
    echo "请使用 POST 请求上传视频或输入链接。";
}

// 调用 Coze API 进行视频处理
function callCozeAPI($videoData) {
    $apiUrl = "https://api.coze.cn/your-api-endpoint";  // Coze API 的 URL
    $apiKey = "your-api-key";  // 替换为你的 API 密钥

    // 设置请求数据
    $data = [
        'videoData' => $videoData,  // 视频文件路径或视频链接
    ];

    // 初始化 cURL 会话
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,  // 设置 API 密钥
    ]);
    
    // 执行 cURL 请求并获取响应
    $response = curl_exec($ch);
    curl_close($ch);

    // 处理 Coze API 的响应
    if ($response === false) {
        echo "API 调用失败";
    } else {
        echo "API 响应: " . $response;
    }
}
?>
