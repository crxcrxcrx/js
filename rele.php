<?php
$host = '127.0.0.1';
$username = 'root';
$password = 'root';
$db = 'js-login';

$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}

$sql = "SELECT `id`, `password` FROM `userinfo`";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $plain_password = $row['password'];
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        $update_sql = "UPDATE `userinfo` SET `password`='$hashed_password' WHERE `id`=$id";
        if (!mysqli_query($conn, $update_sql)) {
            echo "密码更新失败: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
