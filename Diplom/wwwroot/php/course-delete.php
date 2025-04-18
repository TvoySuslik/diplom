<?php
include '../php/config.php';
require_once('../php/db.php');

if (!isset($_COOKIE['admin']) || $_COOKIE['admin'] != '1') {
    header("Location: ../html/course-list.php?error=access_denied");
    exit();
}

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("SELECT file_path FROM Course WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();

        if (!$course) {
            header("Location: ../html/course-list.php?error=course_not_found");
            exit();
        }

        $file_path = $course['file_path'];
        if (file_exists($file_path)) {
            if (!unlink($file_path)) {
                throw new Exception("Ошибка удаления файла");
            }
        }

        $stmt = $conn->prepare("DELETE FROM Course WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: ../html/course-list.php?success=course_deleted");
        } else {
            header("Location: ../html/course-list.php?error=delete_failed");
        }
        $stmt->close();

    } catch (Exception $e) {
        error_log("Ошибка удаления: " . $e->getMessage());
        header("Location: ../html/course-list.php?error=server_error");
    }
} else {
    header("Location: ../html/course-list.php?error=invalid_request");
}

$conn->close();
exit();