<?php
// 引入数据库连接文件
require_once 'db.php';

// 获取可用的 URL
$sql = "SELECT url FROM urls WHERE is_available = 1 ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

// 返回结果
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['url'];
} else {
    echo "没有可用链接宝宝";
}

// 关闭数据库连接
$conn->close();
?>
