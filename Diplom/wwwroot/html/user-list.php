<?php 
include '../php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $siteConfig['title'] ?> - Список пользователей</title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <style>
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .user-table th,
        .user-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .user-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .user-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-link {
            color: #dc3545;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .action-link:hover {
            color: #bb2d3b;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.85em;
        }
        
        .status-admin {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Список пользователей</h1>
        
        <?php if(empty($_COOKIE['login'])): ?>
            <div class="alert error">
                Доступ запрещен. Пожалуйста, <a href="login.php">авторизуйтесь</a>.
            </div>
        <?php else: ?>
            <?php if($_COOKIE['admin'] == '1'): ?>
                <?php
                require_once('../php/db.php');
                $result = $conn->query("SELECT id, login, admin FROM user");
                ?>
                
                <?php if($result->num_rows > 0): ?>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Логин</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['login']) ?></td>
                                <td>
                                    <span class="status-badge <?= $row['admin'] ? 'status-admin' : '' ?>">
                                        <?= $row['admin'] ? 'Администратор' : 'Пользователь' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(!$row['admin']): ?>
                                        <a href="../php/user-block.php?id=<?= $row['id'] ?>" 
                                           class="action-link"
                                           onclick="return confirm('Вы уверены, что хотите заблокировать пользователя?')">
                                            Заблокировать
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Недоступно</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert info">Пользователи не найдены</div>
                <?php endif; ?>
                
                <?php $conn->close(); ?>
                
            <?php else: ?>
                <div class="alert error">Недостаточно прав для просмотра</div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="administration.php" class="btn">Назад</a>
        </div>
    </div>
</body>
</html>