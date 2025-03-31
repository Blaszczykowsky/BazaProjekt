<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $query = $conn->prepare("SELECT id, login, haslo, rola FROM Uzytkownik WHERE login = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($haslo, $user['haslo'])) {
            $_SESSION['user_id'] = $user['ID_Uzytkownika'];
            $_SESSION['user_login'] = $user['login'];
            $_SESSION['user_role'] = $user['rola'];
            header("Location: dashboard.php"); // Przekierowanie po zalogowaniu
            exit();
        } else {
            $_SESSION['error'] = "Nieprawidłowe hasło!";
        }
    } else {
        $_SESSION['error'] = "Nie znaleziono użytkownika!";
    }
    header("Location: index.php"); // Powrót do strony logowania
    exit();
}
?>
