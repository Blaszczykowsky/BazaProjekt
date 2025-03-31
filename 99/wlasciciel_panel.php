<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rola'] !== 'Wlasciciel') {
    header("Location: index.php");
    exit();
}
require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Właściciela</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header>
        <h2>Panel Właściciela</h2>
        <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['login']); ?> (Właściciel)</p>
    </header>

    <nav>
        <ul>
            <li><a href="#produkty">Zarządzanie Produktami</a></li>
            <li><a href="#dostawy">Historia Dostaw</a></li>
            <li><a href="#magazyny">Magazyny</a></li>
            <li><a href="#raporty">Raporty</a></li>
        </ul>
    </nav>

    <main>
        <section id="produkty">
            <h3>Produkty</h3>
            <a href="dodaj_produkt.php" class="btn">Dodaj Produkt</a>
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
                                        <td>
                                            <a href='edytuj_produkt.php?id={$row['ID_Produktu']}'>Edytuj</a> |
                                            <a href='usun_produkt.php?id={$row['ID_Produktu']}' onclick='return confirm(\"Na pewno usunąć?\");'>Usuń</a>
                                        </td>
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

        <section id="dostawy">
            <h3>Historia Dostaw</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produkt</th>
                            <th>Data</th>
                            <th>Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT d.ID_Dostawy, p.Nazwa AS Produkt, d.Data_dostawy, d.Ilosc
                                  FROM dostawy d
                                  JOIN produkty p ON d.ID_Produktu = p.ID_Produktu";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['ID_Dostawy']}</td>
                                        <td>{$row['Produkt']}</td>
                                        <td>{$row['Data_dostawy']}</td>
                                        <td>{$row['Ilosc']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Brak danych o dostawach</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="magazyny">
            <h3>Magazyny</h3>
            <a href="dodaj_magazyn.php" class="btn">Dodaj Magazyn</a>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lokalizacja</th>
                            <th>Pojemność</th>
                            <th>Akcje</th>
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
                                        <td><a href='edytuj_magazyn.php?id={$row['ID_Magazynu']}'>Edytuj</a></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Brak magazynów</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="raporty">
            <h3>Raporty</h3>
            <a href="raporty.php" class="btn">Zobacz Raporty</a>
        </section>
    </main>

    <footer>
        <a href="logout.php" class="logout-btn">Wyloguj się</a>
    </footer>
</div>
</body>
</html>
