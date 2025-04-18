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
        $repeatpassword = $_POST['repeatpassword'];

        if (empty($login) || empty($password) || empty($repeatpassword)) {
            echo "Заполнены не все поля.<br>Вы будете перенаправлены<br>к форме регистрации через 5 секунд.";
            $delay = 5;
            $redirectUrl = "../html/sign-up.php";
            header("Refresh: $delay; URL=$redirectUrl");
            exit;
        } else {
            if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
                echo "Логин может содержать только английские буквы и цифры.<br>Вы будете перенаправлены<br>к форме регистрации через 5 секунд.";
                $delay = 5;
                $redirectUrl = "../html/sign-up.php";
                header("Refresh: $delay; URL=$redirectUrl");
                exit;
            } elseif ($password != $repeatpassword) {
                echo "Пароли не совпадают.<br>Вы будете перенаправлены<br>к форме регистрации через 5 секунд.";
                $delay = 5;
                $redirectUrl = "../html/sign-up.php";
                header("Refresh: $delay; URL=$redirectUrl");
                exit;
            } else {
                $sql_check = "SELECT * FROM `User` WHERE login='$login'";
                $result = $conn->query($sql_check);

                if ($result->num_rows > 0) {
                    echo "Логин уже существует.<br>Вы будете перенаправлены<br>к форме регистрации через 5 секунд.";
                    $delay = 5;
                    $redirectUrl = "../html/sign-up.php";
                    header("Refresh: $delay; URL=$redirectUrl");
                    exit;
                } else {
                    $password = md5($password."G5ix9bdk62qwe12");
                    $sql = "INSERT INTO `User` (login, password) VALUES ('$login', '$password')";
                    if ($conn->query($sql) === TRUE) {
                        echo "Успешная регистрация.<br>Вы будете перенаправлены<br>к форме входа через 5 секунд.";
                        $delay = 5;
                        $redirectUrl = "../html/home.php";
                        header("Refresh: $delay; URL=$redirectUrl");
                        exit;
                    } else {
                        echo "Ошибка: " . $conn->error;
                    }
                }
            }
        }
        ?>
    </div>
</body>
</html>