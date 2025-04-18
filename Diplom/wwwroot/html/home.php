<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
    <h1><?= $siteConfig['title'] ?></h1>
        <?php
            if($_COOKIE['login'] == ''):
        ?>
        <form action="../php/log-in.php" method="post">
            <h1>Вход</h1>
            <input type="text" autocomplete="off" class="form-control" name="login" id="login" placeholder="Логин" required>
            <input type="password" class="form-control" name="password" id="password" placeholder="Пароль" required><br>
            <button class="btn-login" type="submit">Войти</button>
        </form>
        <div class="back-link">
            <a href="sign-up.php">У вас нет аккаунта?</a>
        </div>
        <?php else: ?> 
        <p class="welcome-text">Привет <?=$_COOKIE['login']?>.</p>
        <div class="buttons">
        <a class="btn" href="course-search.php">Список курсов</a>
            <?php
            if($_COOKIE['admin'] == '1'):
            ?>
            <a class="btn" href="administration.php">Администрирование</a>
            <?php endif ?>
            <a class="btn" href="../php/exit.php">Выход из аккаунта</a>
        </div>
        <?php endif ?>  
    </div>
</body>
</html>