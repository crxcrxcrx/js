<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $host = '127.0.0.1';
    $db_username = 'root';
    $db_password = 'root';
    $db = 'js-login';

    header('content-type:text/html;charset=utf-8;');

    $conn = mysqli_connect($host, $db_username, $db_password, $db);

    if (!$conn) {
        die("连接失败: " . mysqli_connect_error());
    }

    // 使用准备语句防止SQL注入
    $stmt = $conn->prepare("SELECT * FROM `userinfo` WHERE `username` = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $res = $stmt->get_result();

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        // 使用 password_verify 验证密码
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $name;
            echo "<script>alert('登录成功'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('密码错误'); window.location.href = 'login.html';</script>";
        }
    } else {
        // 用户不存在
        echo "<script>alert('用户名不存在'); window.location.href = 'login.html';</script>";
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo "<script>alert('无效请求'); window.location.href = 'login.html';</script>";
}
?>
