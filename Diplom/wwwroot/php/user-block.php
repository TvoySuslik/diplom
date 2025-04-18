<?php
require_once('db.php');
require_once('config.php');

if (!isset($_COOKIE['admin']) || $_COOKIE['admin'] != '1') {
    header("Location: ../html/user-list.php?error=access_denied");
    exit();
}

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM user WHERE id = ? AND admin = 0");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: ../html/user-list.php?success=user_blocked");
        } else {
            header("Location: ../html/user-list.php?error=block_failed");
        }
    } catch (Exception $e) {
        error_log("Ошибка блокировки: " . $e->getMessage());
        header("Location: ../html/user-list.php?error=server_error");
    }
} else {
    header("Location: ../html/user-list.php?error=invalid_request");
}

$conn->close();