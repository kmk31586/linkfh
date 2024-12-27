<?php
// 引入数据库连接
require_once 'db.php';

// 设置响应头为 JSON
header('Content-Type: application/json');

// 获取 URL ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 验证参数
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => '无效的 URL ID']);
    exit;
}

// 删除指定 ID 的 URL
$sql = "DELETE FROM urls WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'URL 删除成功']);
} else {
    echo json_encode(['success' => false, 'message' => '删除失败']);
}

// 关闭数据库连接
$stmt->close();
$conn->close();
?>