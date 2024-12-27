<?php
// 引入数据库连接
require_once 'db.php';

// 设置响应头为 JSON
header('Content-Type: application/json');

// 获取参数
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 验证参数
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => '无效的 URL ID']);
    exit;
}

// 查询当前 URL 的状态
$sql = "SELECT is_available FROM urls WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// 检查 URL 是否存在
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => '未找到指定的 URL']);
    $stmt->close();
    $conn->close();
    exit;
}

// 获取当前状态
$row = $result->fetch_assoc();
$current_status = $row['is_available'];

// 切换状态：如果当前是 1（启用），则改为 0（禁用）；反之亦然
$new_status = ($current_status == 1) ? 0 : 1;

// 更新 URL 状态
$sql = "UPDATE urls SET is_available = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $new_status, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => '状态更新成功', 'new_status' => $new_status]);
} else {
    echo json_encode(['success' => false, 'message' => '状态更新失败']);
}

// 关闭数据库连接
$stmt->close();
$conn->close();
?>
