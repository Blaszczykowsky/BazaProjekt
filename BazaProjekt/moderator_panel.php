<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Moderator') {
    header("Location: index.php");
    exit();
}
include("db.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Moderatora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Panel Moderatora</h2>
            <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['user_login']); ?></p>
        </header>
        
        <nav>
            <ul>
                <li><a href="#produkty">Zarządzanie Produktami</a></li>
                <li><a href="#zamowienia">Zarządzanie Zamówieniami</a></li>
                <li><a href="#klienci">Zarządzanie Klientami</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="produkty">
                <h3>Zarządzanie Produktami</h3>
                <div class="action-buttons">
                    <a href="dodaj_produkt.php" class="btn">Dodaj Produkt</a>
                    <a href="edytuj_produkt.php" class="btn">Edytuj Produkt</a>
                </div>
                
                <div class="data-table">
                    <h4>Lista Produktów</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa</th>
                                <th>Cena</th>
                                <th>Kategoria</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT ID_Produktu, Nazwa, Cena, Kategoria FROM produkt";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Produktu']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nazwa']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Cena']) . " zł</td>";
                                    echo "<td>" . htmlspecialchars($row['Kategoria']) . "</td>";
                                    echo "<td>
                                            <a href='edytuj_produkt.php?id=" . $row['ID_Produktu'] . "'>Edytuj</a> | 
                                            <a href='szczegoly_produkt.php?id=" . $row['ID_Produktu'] . "'>Szczegóły</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Brak produktów</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section id="zamowienia">
                <h3>Zarządzanie Zamówieniami</h3>
                
                <div class="data-table">
                    <h4>Lista Zamówień</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Klient</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Suma</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT z.ID_Zamowienia, k.Imie, k.Nazwisko, z.Data, z.Status, z.Suma 
                                      FROM zamowienie z 
                                      JOIN klient k ON z.ID_Klienta = k.ID_Klienta";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Zamowienia']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Imie']) . " " . htmlspecialchars($row['Nazwisko']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Data']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Suma']) . " zł</td>";
                                    echo "<td>
                                            <a href='zmien_status.php?id=" . $row['ID_Zamowienia'] . "'>Zmień Status</a> | 
                                            <a href='szczegoly_zamowienia.php?id=" . $row['ID_Zamowienia'] . "'>Szczegóły</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Brak zamówień</td></tr>";
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