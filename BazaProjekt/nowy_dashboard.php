<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
} 

// Przekierowanie do odpowiedniego panelu w zależności od roli
if (isset($_SESSION['user_role'])) {
    $role = $_SESSION['user_role'];
    
    switch ($role) {
        case 'SuperAdmin':
            header("Location: admin_panel.php");
            exit();
        case 'Moderator':
            header("Location: moderator_panel.php");
            exit();
        case 'Magazynier':
            header("Location: magazynier_panel.php");
            exit();
        case 'Klient':
            header("Location: klient_panel.php");
            exit();
        case 'Wlasciciel':
            header("Location: wlasciciel_panel.php");
            exit();
        default:
            // Domyślny panel dla nieznanych ról
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Witaj, <?php echo htmlspecialchars($_SESSION['user_login']); ?>!</h2>
            <p>Rola: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
        </header>
        
        <main>
            <div class="dashboard-content">
                <p>To jest domyślny panel użytkownika. Wybierz jedną z opcji poniżej:</p>
                
                <div class="dashboard-options">
                    <a href="profil.php" class="option-box">Mój profil</a>
                    <a href="#" class="option-box">Ustawienia</a>
                    <a href="#" class="option-box">Historia</a>
                </div>
            </div>
        </main>
        
        <footer>
            <a href="logout.php" class="logout-btn">Wyloguj się</a>
        </footer>
    </div>
</body>
</html>