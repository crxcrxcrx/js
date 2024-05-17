<?php
// 数据库配置
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$database = "js-login";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $database);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 查询数据库中之前的留言
$sql = "SELECT user, message FROM comments";
$result = $conn->query($sql);

// 检查查询结果是否有效
if ($result->num_rows > 0) {
    // 输出每条留言
    while ($row = $result->fetch_assoc()) {
        echo "用户: " . $row["user"]. " - 留言: " . $row["message"]. "<br>";
    }
} else {
    echo "暂无留言";
}

// 关闭数据库连接
$conn->close();
?>
