<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['confirm_password'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $confirm_pass = $_POST['confirm_password'];

    // 密码确认校验
    if ($pass !== $confirm_pass) {
        echo "<script>alert('两次输入的密码不一致'); window.location.href = 'register.html';</script>";
        exit();
    }

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
        echo "<script>alert('用户名已存在'); window.location.href = 'register.html';</script>";
    } else {
        // 用户不存在，进行注册
        $sql = "INSERT INTO `userinfo` (`username`, `password`,`email`,`phone`)
VALUES ('$name', '$pass','$email','$phone')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('注册成功'); window.location.href = 'login.html';</script>";
} else {
    echo "<script>alert('注册失败'); window.location.href = 'register.html';</script>";
}
}

mysqli_close($conn);
} else {
echo "<script>alert('无效请求'); window.location.href = 'register.html';</script>";
}
?>
