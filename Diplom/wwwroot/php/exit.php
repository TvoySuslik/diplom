<?php
    setcookie('login', $login['login'], time() - 3600 * 24 * 7, "/");
    setcookie('admin', $admin['admin'], time() - 3600 * 24 * 7, "/");
    header('Location: ../html/home.php');
?>