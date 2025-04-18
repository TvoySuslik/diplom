<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
        <?php
        require_once('db.php');
        
        $login = $_POST['login'];
        $password = $_POST['password'];
        $admin = $_POST['admin'];

        if(empty($login) || empty($password)) {
            echo "Заполните все поля.<br>Вы будете перенаправлены<br>к форме входа через 5 секунд.";
            $delay = 5;
            $redirectUrl = "../html/home.php";
            header("Refresh: $delay; URL=$redirectUrl");
            exit;
        } else {
            $password = md5($password . "G5ix9bdk62qwe12");
            $sql = "SELECT * FROM `User` WHERE login = '$login' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    setcookie('login', $login, time() + 3600 * 24 * 7, "/");
                    $admin = $row['admin'];
                    setcookie('admin', $admin, time() + 3600 * 24 * 7, "/");
                    $delay = 0;
                    $redirectUrl = "../html/home.php";
                    header("Refresh: $delay; URL=$redirectUrl");
                    exit;
                }
            } else {
                echo "Неверные данные.<br>Вы будете перенаправлены<br>к форме входа через 5 секунд.";
                $delay = 5;
                $redirectUrl = "../html/home.php";
                header("Refresh: $delay; URL=$redirectUrl");
                exit;
            }
        }
        ?>
    </div>
</body>
</html>