<?php
// 引入数据库连接配置文件
require_once 'db.php';  // 你可以根据实际路径调整文件的引入路径

// 检测URL状态的函数
function checkUrlStatus($url) {
    // 麒麟检测的用户名和密钥
    $apiUrl = "https://api.uouin.com/app/wx?username=用户名&key=密钥&url=" . urlencode($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return null;  // 请求失败时返回null
    }

    $data = json_decode($response, true);
    
    if (isset($data['code'])) {
        $code = $data['code'];
        
        if ($code == 1001) {
            return 1; // URL正常
        } elseif ($code == 1002) {
            return 0; // URL被封禁
        }
    }

    return null; // 未知的返回状态
}

// 获取所有URL并更新状态
$sql = "SELECT id, url, is_available FROM urls";
$result = $conn->query($sql); // 使用 mysqli 连接执行查询

if ($result->num_rows > 0) {
    while ($urlRecord = $result->fetch_assoc()) {
        $url = $urlRecord['url'];
        $id = $urlRecord['id'];
        $currentStatus = $urlRecord['is_available']; // 获取当前的状态

        // 检测URL状态
        $status = checkUrlStatus($url);

        if ($status === null) {
            echo "URL: $url 无法检测或返回无效状态\n";
            continue; // 如果无法检测状态，跳过此URL
        }

        // 如果当前状态与检测到的状态相同，则跳过更新
        if ($currentStatus == $status) {
            echo "URL: $url 当前状态已是 " . ($status == 1 ? '正常' : '被封禁') . "，无需更新\n";
            continue; // 跳过更新
        }

        // 更新状态到数据库
        $updateSql = "UPDATE urls SET is_available = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $status, $id);
        $updateStmt->execute();

        echo "URL: $url 状态已更新为: " . ($status == 1 ? '正常' : '被封禁') . "\n";
    }
} else {
    echo "没有找到任何URL记录\n";
}
?>
