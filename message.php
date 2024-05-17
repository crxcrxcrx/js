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

// 检查是否提交了表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 检查用户名和留言字段是否都被设置
    if (isset($_POST["username"]) && isset($_POST["comment"])) {
        // 从表单中获取用户名和留言
        $username = $_POST["username"];
        $comment = $_POST["comment"];

        // 准备并绑定 SQL 语句用于插入新留言
        $stmt = $conn->prepare("INSERT INTO comments (user, message) VALUES (?, ?)");

        // 检查准备 SQL 语句是否成功
        if (!$stmt) {
            die("错误：" . $conn->error); // 添加错误处理
        }

        // 绑定参数
        $stmt->bind_param("ss", $username, $comment);

        // 执行 SQL 语句
        $result = $stmt->execute();

        // 检查执行是否成功
        if (!$result) {
            die("错误：" . $stmt->error); // 添加错误处理
        }

        // 关闭语句
        $stmt->close();

        // 重定向回留言页面
        header("Location: message.php");
        exit;
    }
}

// 查询数据库中之前的留言
$sql = "SELECT user, message FROM comments";
$result = $conn->query($sql);

// 准备一个变量来存储所有留言
$comments = "";

// 检查查询结果是否有效
if ($result->num_rows > 0) {
    // 输出每条留言
    while ($row = $result->fetch_assoc()) {
        $comments .= "<p>用户: " . htmlspecialchars($row["user"]) . " - 留言: " . htmlspecialchars($row["message"]) . "</p>";
    }
} else {
    $comments = "<p>暂无留言</p>";
}

// 关闭数据库连接
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音乐网站</title>
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- 头部 -->
    <header class="header">
        <div class="w nav">
            <ul class="nav-meau">
                <li class="active"><a href="index.html">音乐馆</a></li>
                <li><a href="singer.html">歌手</a></li>
                <li><a href="song-list.html">歌单</a></li>
                <li><a href="song.html">歌曲</a></li>
                <li><a href="login.html">登录</a></li>
                <li><a href="message.php">给我们留言</a></li>
            </ul>
            <div class="search">
                <input type="text" name="" id="" placeholder="音乐、MV、歌手等"><button>搜索</button>
            </div>
        </div>
    </header>
    <div class="container">
        <h1>给我们留言吧~</h1>
        <form id="commentForm" action="message.php" method="post">
            <input type="text" id="username" name="username" placeholder="用户名" required>
            <textarea id="comment" name="comment" placeholder="留言内容" required></textarea>
            <button type="submit">提交</button>
        </form>
        <div id="commentsContainer">
            <?php echo $comments; ?>
        </div>
    </div>
    <!-- 底部1 -->
    <footer class="footer py-3">
        <div class="w">
            <div class="links">
                <div class="tit">友情链接</div>
                <a href="#">哔哩哔哩</a>
                <a href="#">淘宝店铺</a>
                <a href="#">拼多多店铺</a>
                <a href="#">闲鱼店铺</a>
                <a href="#">
                    微信
                    <div class="hide">
                        <img src="#" alt="">
                    </div>
                </a>
                <a href="#">
                    QQ
                    <div class="hide">
                        <img src="#" alt="">
                    </div>
                </a>
                <a href="#">
                    抖音
                    <div class="hide">
                        <img src="#" alt="">
                    </div>
                </a>
                <a href="#">小红书</a>
                <p class="mt-2">Copyright © 1998 - 2022 Musi. All Rights Reserved.</p>
            </div>
            <div class="copy">
                <div class="tit">合作伙伴</div>
                <div class="list">
                    <div class="item">
                        <img src="./images/bili-1.png" alt="">
                        <p>三连协会</p>
                    </div>
                    <div class="item">
                        <img src="./images/bili-2.png" alt="">
                        <p>白嫖没对象协会</p>
                    </div>
                    <div class="item">
                        <img src="./images/bili-3.png" alt="">
                        <p>吃瓜群众协会</p>
                    </div>
                    <div class="item">
                        <img src="./images/bili-4.png" alt="">
                        <p>小破站协会</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
