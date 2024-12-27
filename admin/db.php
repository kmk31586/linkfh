<?php
// db.php: 数据库连接文件

$servername = "localhost";
$username = "aaa";
$password = "aaa";
$dbname = "aaa";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
