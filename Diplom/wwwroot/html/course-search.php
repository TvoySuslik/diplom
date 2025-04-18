<?php
include '../php/config.php';
require_once('../php/db.php');

$courses = [];
if (isset($_COOKIE['login'])) {
    $result = $conn->query("SELECT id, name FROM Course ORDER BY name");
    if ($result) $courses = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог курсов - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <style>
        .course-grid {
            display: grid;
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .course-item {
            padding: 1.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Доступные курсы</h1>
        
        <?php if(empty($_COOKIE['login'])): ?>
            <div class="alert">
                Для доступа требуется <a href="login.php">авторизация</a>
            </div>
        <?php else: ?>
            <div class="course-grid">
                <?php foreach($courses as $course): ?>
                    <div class="course-item">
                        <h3><?= htmlspecialchars($course['name']) ?></h3>
                        <a href="course-view.php?id=<?= $course['id'] ?>" 
                           class="btn">
                            Открыть курс
                        </a>
                    </div>
                <?php endforeach; ?>
                
                <?php if(empty($courses)): ?>
                    <p>Пока нет доступных курсов</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="home.php">Назад</a>
        </div>
    </div>
</body>
</html>