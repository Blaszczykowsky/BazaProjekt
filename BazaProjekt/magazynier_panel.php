<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Magazynier') {
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
    <title>Panel Magazyniera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Panel Magazyniera</h2>
            <p>Zalogowany jako: <?php echo htmlspecialchars($_SESSION['user_login']); ?></p>
        </header>
        
        <nav>
            <ul>
                <li><a href="#dostawy">Zarządzanie Dostawami</a></li>
                <li><a href="#magazyn">Stan Magazynu</a></li>
                <li><a href="#wydania">Wydania Towaru</a></li>
            </ul>
        </nav>
        
        <main>
            <section id="dostawy">
                <h3>Zarządzanie Dostawami</h3>
                <div class="action-buttons">
                    <a href="dodaj_dostawe.php" class="btn">Zarejestruj Dostawę</a>
                    <a href="zaktualizuj_status.php" class="btn">Aktualizuj Status</a>
                </div>
                
                <div class="data-table">
                    <h4>Lista Dostaw</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Magazyn</th>
                                <th>Data</th>
                                <th>Dostawca</th>
                                <th>Status</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT d.ID_Dostawy, m.Lokalizacja, d.Data_dostawy, d.Dostawca, d.Status 
                                      FROM dostawa d 
                                      JOIN magazyn m ON d.ID_Magazynu = m.ID_Magazynu";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Dostawy']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Lokalizacja']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Data_dostawy']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Dostawca']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                    echo "<td>
                                            <a href='aktualizuj_status.php?id=" . $row['ID_Dostawy'] . "'>Aktualizuj</a> | 
                                            <a href='szczegoly_dostawy.php?id=" . $row['ID_Dostawy'] . "'>Szczegóły</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Brak dostaw</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section id="magazyn">
                <h3>Stan Magazynu</h3>
                
                <div class="data-table">
                    <h4>Lokalizacje Magazynowe</h4>
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
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Magazynu']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Lokalizacja']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Pojemnosc']) . "</td>";
                                    echo "<td>
                                            <a href='pokaz_produkty.php?id=" . $row['ID_Magazynu'] . "'>Pokaż Produkty</a> | 
                                            <a href='inwentaryzacja.php?id=" . $row['ID_Magazynu'] . "'>Inwentaryzacja</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Brak magazynów</td></tr>";
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