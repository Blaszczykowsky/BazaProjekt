<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Magazynier') {
    header("Location: index.php");
    exit();
}
require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Magazyniera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Panel Magazyniera</h2>
            <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['login']); ?> (Magazynier)</p>
        </header>
        
        <nav>
            <ul>
                <li><a href="#produkty">Zarządzanie Ilością Produktów</a></li>
                <li><a href="dodaj_dostawe.php">Rejestruj Nową Dostawę</a></li>
                <li><a href="#magazyny">Magazyny</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="produkty">
                <h3>Lista Produktów</h3>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa</th>
                                <th>Kategoria</th>
                                <th>Cena</th>
                                <th>Ilość</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM produkty";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['ID_Produktu']}</td>
                                            <td>{$row['Nazwa']}</td>
                                            <td>{$row['Kategoria']}</td>
                                            <td>{$row['Cena']}</td>
                                            <td>{$row['Ilosc']}</td>
                                            <td><a href='edytuj_ilosc_produktu.php?id={$row['ID_Produktu']}'>Zmień ilość</a></td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Brak produktów</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="magazyny">
                <h3>Lista Magazynów</h3>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lokalizacja</th>
                                <th>Pojemność</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM magazyn";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['ID_Magazynu']}</td>
                                            <td>{$row['Lokalizacja']}</td>
                                            <td>{$row['Pojemnosc']}</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Brak magazynów</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        
        <footer>
            <a href="logout.php" class="logout-btn">Wyloguj się</a>
        </footer>
    </div>
</body>
</html>
