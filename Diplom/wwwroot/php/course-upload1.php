<?php
require_once('db.php');
require_once('config.php');

if (!isset($_COOKIE['admin']) || $_COOKIE['admin'] != '1') {
    header("Location: course-upload.php?error=access_denied");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $score = (float)$_POST['score'];
    
    if (empty($name) || $score < 0 || $score > 5) {
        die("Некорректные данные");
    }

    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $allowed_ext = ['docx'];
        $file_name = $_FILES['file']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (!in_array($file_ext, $allowed_ext)) {
            die("Разрешены только файлы .docx");
        }

        $upload_dir = __DIR__ . '/../uploads/courses/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_file_name = uniqid() . '_' . basename($file_name);
        $file_path = $upload_dir . $new_file_name;

        if (file_exists($file_path)) {
            die("Файл с таким именем уже существует");
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            try {
                $stmt_check = $conn->prepare("SELECT id FROM Course WHERE name = ?");
                $stmt_check->bind_param("s", $name);
                $stmt_check->execute();
                
                if ($stmt_check->get_result()->num_rows > 0) {
                    unlink($file_path);
                    die("Курс с таким названием уже существует");
                }

                $stmt = $conn->prepare("INSERT INTO Course 
                    (name, score, file_path) 
                    VALUES (?, ?, ?)");
                
                $stmt->bind_param("sds", $name, $score, $file_path);
                $stmt->execute();
                
                header("Location: ../html/course-list.php?success=course_uploaded");
                
            } catch (Exception $e) {
                error_log("Ошибка: " . $e->getMessage());
                die("Ошибка при сохранении данных");
            }
        } else {
            die("Ошибка при загрузке файла");
        }
    } else {
        die("Ошибка при получении файла");
    }
} else {
    header("Location: course-upload.php");
}

$conn->close();