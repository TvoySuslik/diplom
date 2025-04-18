<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <form action="../php/sign-up.php" method="post" autocomplete="off">
            <input type="text" name="login" id="login" placeholder="Логин" required>
            <input type="password" name="password" id="password" placeholder="Пароль" required>
            <input type="password" name="repeatpassword" id="repeatpassword" placeholder="Повторите пароль" required>
            <button class="btn-login" type="submit">Зарегистрироваться</button>
        </form>
        
        <div class="back-link">
            <a href="home.php">Назад</a>
        </div>
    </div>
</body>
</html>