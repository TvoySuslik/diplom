<?php
include '../php/config.php';
require_once('../php/db.php');

if (!isset($_COOKIE['admin']) || $_COOKIE['admin'] != '1') {
    header("Location: course-list.php?error=access_denied");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $score = $_POST['score'];
    $file_path = $_POST['file_path'];

    try {
        $stmt = $conn->prepare("UPDATE Course SET 
            name = ?, 
            score = ?, 
            file_path = ? 
            WHERE id = ?");
        
        $stmt->bind_param("sdsi", $name, $score, $file_path, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: course-list.php?success=course_updated");
        } else {
            header("Location: course-list.php?error=no_changes");
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Ошибка обновления: " . $e->getMessage());
        header("Location: course-list.php?error=update_failed");
    }
} else {
    header("Location: course-list.php?error=invalid_request");
}

$conn->close();
exit();