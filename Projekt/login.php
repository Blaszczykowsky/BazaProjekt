<?php
session_start();
require_once 'db.php';

$blad = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $query = $conn->prepare("SELECT ID_Uzytkownika, Login, Haslo, Rola FROM uzytkownicy WHERE Login = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($haslo === $user['Haslo']) {
            $_SESSION['zalogowany'] = true;
            $_SESSION['login'] = $user['Login'];
            $_SESSION['id'] = $user['ID_Uzytkownika'];
            $_SESSION['rola'] = $user['Rola'];

            switch ($user['Rola']) {
                case 'Admin':
                    header('Location: admin_panel.php');
                    break;
                case 'Magazynier':
                    header('Location: magazynier_panel.php');
                    break;
                case 'Wlasciciel':
                    header('Location: wlasciciel_panel.php');
                    break;
                case 'Klient':
                    header('Location: klient_panel.php');
                    break;
                default:
                    header('Location: dashboard.php');
            }
            exit;
        } else {
            $blad = "Nieprawidłowe hasło.";
        }
    } else {
        $blad = "Nieprawidłowy login.";
    }

    $query->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Logowanie</h1>
    <?php if (!empty($blad)): ?>
        <div class="alert alert-error"><?php echo $blad; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" required>

        <label for="haslo">Hasło:</label>
        <input type="password" name="haslo" id="haslo" required>

        <input type="submit" value="Zaloguj się">
    </form>
</div>
</body>
</html>
