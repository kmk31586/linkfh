<?php
// 引入数据库连接文件
require_once 'db.php';

// 设置响应类型为 JSON
header('Content-Type: application/json');

// 获取输入的 URL 列表
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $urls = isset($_POST['urls']) ? explode("\n", trim($_POST['urls'])) : [];

    // 限制每次最多 50 条 URL
    if (count($urls) > 50) {
        echo json_encode(['success' => false, 'error' => '最多只能添加 50 条 URL']);
        exit;
    }

    // 存储已存在的 URL，避免重复插入
    $duplicateUrls = [];
    $success = true;
    
    foreach ($urls as $url) {
        $url = trim($url);
        
        // 验证 URL 是否有效
        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            // 检查数据库中是否已存在该 URL
            $sqlCheck = "SELECT COUNT(*) FROM urls WHERE url = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("s", $url);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($count > 0) {
                // 如果 URL 已存在，则将其添加到重复 URL 列表中
                $duplicateUrls[] = $url;
            } else {
                // 如果 URL 不重复，则插入到数据库
                $sql = "INSERT INTO urls (url, is_available) VALUES (?, 1)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $url);
                if (!$stmt->execute()) {
                    $success = false;
                    break;
                }
            }
        }
    }

    // 返回操作结果
    if ($success) {
        if (!empty($duplicateUrls)) {
            echo json_encode(['success' => true, 'message' => '部分 URL 已存在，跳过插入。', 'duplicates' => $duplicateUrls]);
        } else {
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => '数据库操作失败，请稍后再试。']);
    }
}

// 关闭数据库连接
$conn->close();
?>
