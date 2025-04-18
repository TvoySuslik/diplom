<?php
include '../php/config.php';
require_once('../php/db.php');

if (!isset($_COOKIE['admin']) || $_COOKIE['admin'] != '1') {
    header("Location: course-list.php?error=access_denied");
    exit();
}

$course = [];
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM Course WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();
}

if (!$course) {
    die("Курс не найден");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование курса - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
</head>
<body>
    <div class="container">
        <h1>Редактирование курса</h1>
        
        <form action="../html/course-update.php" method="POST">
            <input type="hidden" name="id" value="<?= $course['id'] ?>">
            
            <div class="form-group">
                <label>Название курса:</label>
                <input type="text" name="name" required 
                       value="<?= htmlspecialchars($course['name']) ?>">
            </div>

            <div class="form-group">
                <label>Оценка:</label>
                <input type="number" step="0.1" name="score" required
                       value="<?= $course['score'] ?>">
            </div>

            <div class="form-group">
                <label>Путь к файлу:</label>
                <input type="text" name="file_path" required
                       value="<?= htmlspecialchars($course['file_path']) ?>">
            </div>

            <button type="submit" class="btn-login">Сохранить изменения</button>
        </form>

        <div class="back-link">
            <a href="course-list.php">Назад</a>
        </div>
    </div>
</body>
</html>