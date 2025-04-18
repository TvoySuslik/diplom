<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список курсов - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <style>
        .container {
            width: 100%;
            max-width: 1200px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .actions {
            white-space: nowrap;
        }
        .back-link {
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Список курсов</h1>
        <?php if($_COOKIE['login'] == ''): ?>
            <p>Доступ запрещён</p>
        <?php else: ?>
            <?php if($_COOKIE['admin'] == '1'): ?>
                <?php
                require_once('../php/db.php');
                $sql = "SELECT * FROM Course";
                $result = $conn->query($sql);
                ?>

                <?php if($result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Оценка</th>
                                <th>Файл</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= $row['score'] ?></td>
                                <td><?= basename($row['file_path']) ?></td>
                                <td class="actions">
                                    <a href="course-edit.php?id=<?= $row['id'] ?>" class="btn">Редактировать</a>
                                    <a href="../php/course-delete.php?id=<?= $row['id'] ?>" 
                                       class="btn" 
                                       onclick="return confirm('Удалить курс навсегда?')">Удалить</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Нет доступных курсов</p>
                <?php endif; ?>
                
                <?php $conn->close(); ?>
                
            <?php else: ?>
                <p>Недостаточно прав для просмотра</p>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="administration.php" class="btn">Назад</a>
        </div>
    </div>
</body>
</html>