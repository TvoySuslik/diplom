<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администрирование - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
        <h1>Администрирование</h1>   
        <?php if($_COOKIE['login'] == ''): ?>
            <p>Доступ запрещён</p>
        <?php else: ?> 
            <?php if($_COOKIE['admin'] == '1'): ?>
                <div class="buttons">
                    <a class="btn" href="course-upload.php">Загрузка курсов</a>
                    <a class="btn" href="course-list.php">Управление курсами</a>
                    <a class="btn" href="user-list.php">Список пользователей</a>
                </div>
            <?php else: ?> 
                <p>Недостаточно прав для доступа</p>
            <?php endif ?> 
        <?php endif ?>  
        <div class="back-link">
            <a href="home.php">Назад</a>
        </div>
    </div>
</body>
</html>