<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <form action="login.php" method="POST">
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="haslo" placeholder="Hasło" required><br>
        <button type="submit">Zaloguj</button>
    </form>

    <?php 
    if(isset($_SESSION['error'])) { 
        echo "<p>" . htmlspecialchars($_SESSION['error']) . "</p>"; 
        unset($_SESSION['error']); 
    } 
    ?>
</body>
</html>
