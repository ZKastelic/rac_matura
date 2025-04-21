<?php
session_start();
require_once('funkcije.php');
require_once('db.php');

// Preveri, če je uporabnik prijavljen
if (!isset($_SESSION['username'])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <title>Shopping Cart</title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        ' . Navbar() . '
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-header bg-danger text-white">
                            Dostop zavrnjen
                        </div>
                        <div class="card-body">
                            <p class="card-text">Za dostop do košarice se morate prijaviti.</p>
                            <a href="login.php" class="btn btn-primary">Prijavite se</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ' . Footer() . '
    </body>
    </html>';
    exit;
}

$sql = "SELECT * FROM rso_prijava WHERE username = ?"; // Fixed SQL syntax
$stmt = $db->prepare($sql); // Prepare SQL query
$stmt->bind_param("s", $_SESSION['username']); // Bind username parameter
$stmt->execute(); // Execute SQL query
$u = $stmt->get_result(); // Get query result
$user = $u->fetch_assoc(); // Fetch user data

$id_kupca = $user['id']; // Predpostavimo, da je ID uporabnika shranjen v seji

// Pridobi vse izdelke iz košarice za trenutnega uporabnika
$sql = "SELECT * FROM kosarica WHERE id_kupca = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id_kupca);
$stmt->execute();
$rezultat = $stmt->get_result();

// Izračunaj skupni znesek za trenutnega uporabnika
$sql_total = "SELECT SUM(cena * kolicina) AS skupna_cena FROM kosarica WHERE id_kupca = ?";
$stmt_total = $db->prepare($sql_total);
$stmt_total->bind_param("i", $id_kupca);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$skupno = $total_result->fetch_assoc()['skupna_cena'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .card {
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-weight: bold;
            
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<?php echo Navbar(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header siv">
                    Vaša košarica <!-- Naslov kartice -->
                </div>
                <div class="card-body svetlo-siv"> <!-- Telo kartice -->
                    <?php if ($rezultat->num_rows > 0): ?> <!-- Če je v rezultatu vsaj ena vrstica (je izdelek v kosarici) -->
                        <table class="table">
                            <thead>
                                <tr> <!-- Prikaže imena atributov -->
                                    <th>Slika</th> 
                                    <th>Izdelek</th>
                                    <th>Količina</th>
                                    <th>Cena</th>
                                    <th>Skupaj</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $rezultat->fetch_assoc()): //Prikaže vse izdelke v kosarici
                                    $tabela = $user['tabela']; // Pridobi ime tabele iz košarice

                                    // Validate and sanitize the table name
                                    $allowed_tables = ['rso_cpu', 'rso_gpu', 'rso_ram', 'rso_storage', 'rso_mobo']; // List of allowed table names
                                    if (!in_array($tabela, $allowed_tables)) {
                                        throw new Exception("Invalid table name: " . htmlspecialchars($tabela));
                                    }
                                    $sql1 = "SELECT * FROM $tabela WHERE ime = ? LIMIT 1"; // Pridobi vse podatke o izdelku iz tabele, ki jo je uporabnik dodal v košarico
                                    $stmt1 = $db->prepare($sql1);
                                    $stmt1->bind_param("s", $user['ime']);
                                    $stmt1->execute();
                                    $rezultat1 = $stmt1->get_result();
                                    $user1 = $rezultat1->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="prikaz.php?id=<?php echo $user1['id']; ?>&num=<?php echo $user1['tip']; ?>" class="text-decoration-none text-body"> <!-- Povezava do prikaza izdelka, če uporabnik klikne na izdelek -->
                                                <?php echo '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user1['slika1']) . '"/>'; ?> <!-- Prikaz slike izdelka -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href="prikaz.php?id=<?php echo $user1['id']; ?>&num=<?php echo $user1['tip']; ?>" class="text-decoration-none text-body"> <!-- Povezava do prikaza izdelka, če uporabnik klikne na izdelek -->
                                                <?php echo htmlspecialchars($user['ime']); ?> <!-- Prikaz imena izdelka -->
                                            </a>
                                        </td>
                                        <td><?php echo $user['kolicina']; ?></td> <!-- Prikaz količine izdelka -->
                                        <td><?php echo number_format($user['cena'], 2); ?> €</td> <!-- Prikaz cene izdelka -->
                                        <td><?php echo number_format($user['cena'] * $user['kolicina'], 2); ?> €</td> <!-- Prikaz skupne cene izdelka (cena * količina) -->
                                        <td>
                                            <form action="odstrani_iz_kosarice.php?id=<?php echo $user['id']?>" method="POST" class="d-inline"> <!-- Obrazec za odstranitev izdelka iz košarice in povezava do odstrani_iz_losarice.php -->
                                                <button type="submit" class="btn btn-danger btn-sm">Odstrani</button> <!-- Gumb za odstranitev izdelka iz košarice -->
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Skupno</th> <!-- Prikaz skupne cene -->
                                    <th><?php echo number_format($skupno, 2); ?> €</th> <!-- Prikaz skupne cene z 2 decimalkami -->
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="text-end">
                            <a href="checkout.php" class="btn btn-success">Na blagajno</a> <!-- Povezava do blagajne (checkout.php) -->
                        </div>
                    <?php else: ?>
                        <p class="text-center">Vaša košarica je prazna.</p> <!-- Prikaz sporočila, če je košarica prazna, če je stavek v vrstici 50 null -->
                        <div class="text-center">
                            <a href="index.php" class="btn btn-success">Nazaj v trgovino</a> <!-- Povezava do trgovine (index.php) -->
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo Footer(); ?>
</body>
</html>