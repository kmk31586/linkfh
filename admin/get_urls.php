<?php
// 引入数据库连接
require_once 'db.php';

// 设置响应头为 JSON
header('Content-Type: application/json');

// 查询数据库中所有 URL
$sql = "SELECT id, url, is_available FROM urls ORDER BY id DESC";
$result = $conn->query($sql);

// 准备 JSON 数据
$urls = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $urls[] = [
            'id' => $row['id'],
            'url' => $row['url'],
            'is_available' => (bool)$row['is_available']
        ];
    }
}

// 返回 JSON 数据
echo json_encode($urls);

// 关闭数据库连接
$conn->close();
?>