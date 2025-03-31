<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    // Uwaga: nazwy tabel i kolumn dopasowane do struktury bazy danych
    $query = $conn->prepare("SELECT ID_Uzytkownika, Login, Haslo, Rola FROM uzytkownik WHERE Login = ?");
    $query->bind_param("s", $login);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Jeśli hasła są haszowane — używamy password_verify. Jeśli nie, użyj: $haslo == $user['Haslo']
        if ($haslo == $user['Haslo']) {
            $_SESSION['user_id'] = $user['ID_Uzytkownika'];
            $_SESSION['user_login'] = $user['Login'];
            $_SESSION['user_role'] = $user['Rola'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Nieprawidłowe hasło!";
        }
    } else {
        $_SESSION['error'] = "Nie znaleziono użytkownika!";
    }
    header("Location: index.php");
    exit();
}
?>
