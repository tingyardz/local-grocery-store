<?php
    session_start();
    unset($_SESSION['admin-login']);
    header("Location:index.php");
    exit();
?>