<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['rola'] !== 'Admin' && $_SESSION['rola'] !== 'SuperAdmin')) {
    header("Location: index.php");
    exit();
}
require_once "db.php";

if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit();
}

$id = intval($_GET['id']);

// Pobierz dane użytkownika
$query = $conn->prepare("SELECT * FROM uzytkownicy WHERE ID_Uzytkownika = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows !== 1) {
    echo "Użytkownik nie istnieje.";
    exit();
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $rola = $_POST['rola'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];

    // Aktualizacja głównej tabeli
    $stmt = $conn->prepare("UPDATE uzytkownicy SET Login = ?, Haslo = ?, Rola = ? WHERE ID_Uzytkownika = ?");
    $stmt->bind_param("sssi", $login, $haslo, $rola, $id);
    $stmt->execute();
    $stmt->close();

    // Usunięcie użytkownika z poprzednich ról
    $conn->query("DELETE FROM admin WHERE ID_Uzytkownika = $id");
    $conn->query("DELETE FROM magazynier WHERE ID_Uzytkownika = $id");
    $conn->query("DELETE FROM wlasciciel WHERE ID_Uzytkownika = $id");
    $conn->query("DELETE FROM klient WHERE ID_Uzytkownika = $id");

    // Wstawienie do nowej roli
    switch ($rola) {
        case 'Admin':
            $stmt = $conn->prepare("INSERT INTO admin (ID_Uzytkownika, Imie, Nazwisko, Telefon, Poziom_dostepu, Zatrudniony_od) VALUES (?, ?, ?, '', 1, NOW())");
            $stmt->bind_param("iss", $id, $imie, $nazwisko);
            break;
        case 'Magazynier':
            $stmt = $conn->prepare("INSERT INTO magazynier (ID_Uzytkownika, Imie, Nazwisko, Stanowisko, Zmiana, Uprawnienia_UDT) VALUES (?, ?, ?, 'brak', 'I', 0)");
            $stmt->bind_param("iss", $id, $imie, $nazwisko);
            break;
        case 'Wlasciciel':
            $stmt = $conn->prepare("INSERT INTO wlasciciel (ID_Uzytkownika, Imie, Nazwisko, NIP, Nazwa_firmy, Adres_firmy) VALUES (?, ?, ?, '', '', '')");
            $stmt->bind_param("iss", $id, $imie, $nazwisko);
            break;
        case 'Klient':
            $stmt = $conn->prepare("INSERT INTO klient (ID_Uzytkownika, Imie, Nazwisko, Email, Numer_telefonu, Miasto, Data_rejestracji) VALUES (?, ?, ?, '', '', '', NOW())");
            $stmt->bind_param("iss", $id, $imie, $nazwisko);
            break;
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: admin_panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj Użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edytuj Użytkownika</h2>
    <form method="post">
        <label>Login: <input type="text" name="login" value="<?php echo htmlspecialchars($user['Login']); ?>" required></label><br>
        <label>Hasło: <input type="text" name="haslo" value="<?php echo htmlspecialchars($user['Haslo']); ?>" required></label><br>
        <label>Rola:
            <select name="rola" required>
                <option value="Admin" <?php if ($user['Rola'] === 'Admin') echo 'selected'; ?>>Admin</option>
                <option value="Magazynier" <?php if ($user['Rola'] === 'Magazynier') echo 'selected'; ?>>Magazynier</option>
                <option value="Wlasciciel" <?php if ($user['Rola'] === 'Wlasciciel') echo 'selected'; ?>>Wlasciciel</option>
                <option value="Klient" <?php if ($user['Rola'] === 'Klient') echo 'selected'; ?>>Klient</option>
            </select>
        </label><br>
        <label>Imię: <input type="text" name="imie" required></label><br>
        <label>Nazwisko: <input type="text" name="nazwisko" required></label><br>
        <button type="submit">Zapisz zmiany</button>
    </form>
    <
