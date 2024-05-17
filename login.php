<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $host = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $db = 'js-login';

    header('content-type:text/html;charset=utf-8;');

    $conn = mysqli_connect($host, $username, $password, $db);

    if (!$conn) {
        die("连接失败: " . mysqli_connect_error());
    }

    // 检查用户是否存在
    $sql = "SELECT * FROM `userinfo` WHERE `username`='$name'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($row['password'] === $pass) {
            $_SESSION['username'] = $name;
            echo "<script>alert('登录成功'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('密码错误'); window.location.href = 'login.html';</script>";
        }
    } else {
        // 用户不存在，进行注册
        $sql = "INSERT INTO `userinfo` (`username`, `password`) VALUES ('$name', '$pass')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $name;
            echo "<script>alert('注册成功并已登录'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('注册失败'); window.location.href = 'login.html';</script>";
        }
    }

    mysqli_close($conn);
} else {
    echo "<script>alert('无效请求'); window.location.href = 'login.html';</script>";
}
?>
