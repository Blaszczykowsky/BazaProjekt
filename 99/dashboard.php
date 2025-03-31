<?php session_start(); if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); } ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>
</head>
<body>
    <h2>Witaj w panelu!</h2>
    <a href="logout.php">Wyloguj</a>
</body>
</html>