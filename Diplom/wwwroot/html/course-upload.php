<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка курса - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
        <h1>Загрузка нового курса</h1>
        
        <?php if($_COOKIE['login'] == ''): ?>
            <p>Доступ запрещён</p>
        <?php else: ?>
            <?php if($_COOKIE['admin'] == '1'): ?>
                <form action="../php/course-upload1.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Название курса:</label>
                        <input type="text" name="name" required 
                            placeholder="Введите название курса">
                    </div>

                    <div class="form-group">
                        <label>Оценка курса:</label>
                        <input type="number" step="0.1" min="0" max="5" 
                            name="score" required placeholder="Пример: 4.5">
                    </div>

                    <div class="form-group">
                        <label>Файл курса (DOCX):</label>
                        <input type="file" name="file" required
                            accept=".docx" 
                            title="Только файлы формата .docx">
                    </div>

                    <button type="submit" class="btn-login">Загрузить курс</button>
                </form>
            <?php else: ?>
                <p>Недостаточно прав</p>
            <?php endif; ?>
        <?php endif; ?>

        <div class="back-link">
            <a href="administration.php" class="btn">Назад</a>
        </div>
    </div>
</body>
</html>